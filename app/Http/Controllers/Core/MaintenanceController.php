<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Http\Requests\MaintenanceRequest;
use App\Models\Dependency;
use App\Models\Hardware;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use App\Models\MTBF;
use App\Models\MTTR;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class MaintenanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        MainController $MainController,
        MTBFController $MTBFController,
        MTTRController $MTTRController
    ) {
        $this->middleware('auth');
        $this->MainController = $MainController;
        $this->mtbf = $MTBFController;
        $this->mttr = $MTTRController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function calculatedAvailibility($mtbf, $mttr)
    {
        $availibility = $mtbf / ($mtbf + $mttr) * 100;
        return number_format($availibility, 2, '.', '');
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Maintenance::with('detail', 'mtbf', 'mttr')->get();
            if (request('filter_period')) {
                $filter_period = now()->subDays(request('filter_period'))->toDateString();
                $data = $data->where('created_at', '>=', $filter_period);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('code', function ($row) {
                    return $row->detail->code;
                })
                ->addColumn('hardware_code', function ($row) {
                    return $row->hardware->code;
                })
                ->addColumn('brand', function ($row) {
                    return $row->hardware->type->brand->name;
                })
                ->addColumn('mtbf', function ($row) {
                    $mtbf = $row->mtbf->total ?? 0;
                    return  $mtbf . " Jam";
                })
                ->addColumn('mttr', function ($row) {
                    $mttr = $row->mttr->total ?? 0;
                    return  $mttr . " Jam";
                })
                ->addColumn('type', function ($row) {
                    if ($row->type == 'replaced') {
                        $status = 'DIGANTI';
                    } else {
                        $status = 'DIPERBAIKI';
                    }
                    return '<span class="badge badge-primary">' . $status . '</span>';
                })
                ->addColumn('date', function ($row) {
                    return Carbon::parse($row->created_at)->isoFormat('dddd, D-MMM-Y');
                })
                ->addColumn('availibility', function ($row) {
                    return $row->availability . "%";
                })
                ->rawColumns(['type'])
                ->make(true);
        }

        return view('pages.backend.data.maintance.indexMaintenance')
            ->with([
                'mtbf' => $this->getStatistics('mtbf', 'total'),
                'mttr' => $this->getStatistics('mttr', 'total'),
                'availibility' => $this->getStatistics('maintenance', 'availability')
            ]);
    }

    public function create()
    {
        $code = $this->getRandomCode();
        $hardware = Hardware::with('type.brand')->get();
        return view('pages.backend.data.maintance.createMaintenance', [
            'code' => $code,
            'hardware' => $hardware,
        ]);
    }

    public function store(MaintenanceRequest $request)
    {
        // Check When Warranty is Available
        $hardware = Hardware::with('type.brand')->find($request->hardware)->warranty_date;
        if ($hardware >= date('Y-m-d')) {
            return response()->json([
                'error' => "Hardware masih dapat di garansikan sampai dengan " . Carbon::parse($hardware)->isoFormat('dddd, D-MMM-Y')
            ], 400);
        }
        $dependency = $request->except([
            'hardware', 'code', 'total_work', 'breakdown',
            'time_breakdown', 'maintenance_time', 'start_time',
            'type', 'notes'
        ]);
        // Split the dependency into two parts        
        $dependencyCount = count($dependency);
        // check data odd
        if ($dependencyCount % 2 != 0) {
            return response()->json([
                'error' => "Data Ketergantungan Hardware Harus Lengkap"
            ], 400);
        }
        // Check Duplicate Maintenance Dependency        
        $duplicate = [];
        $dependencyValues = array_values($dependency);
        foreach ($dependencyValues as $key => $value) {
            // check data odd
            if ($key % 2 != 0) {
                $duplicate[] = $value;
            }
        }
        $duplicate = array_unique($duplicate);
        if (count($duplicate) != ($dependencyCount / 2)) {
            return Response::json([
                'error' => 'Data Maintenance Pada Ketergantungan Hardware Ada yang Sama'
            ], 400);
        }
        $dependency = collect($dependency)->split($dependencyCount / 2);
        // Create Datas
        $mtbfData = $this->mtbf->create($request->total_work, $request->breakdown, $request->time_breakdown);
        $mttrData = $this->mttr->create($request->maintenance_time, $request->start_time);

        // Check Duplicate
        // $mtbf = Maintenance::with('mtbf')->whereHas('mtbf', function ($query) {
        //     $query->whereDate('created_at', '=', date('Y-m-d'));
        // })->where('hardware_id', $request->hardware)->first();
        // $mttr = Maintenance::with('mttr')->whereHas('mttr', function ($query) {
        //     $query->whereDate('created_at', '=', date('Y-m-d'));
        // })->where('hardware_id', $request->hardware)->first();
        // $maintenance = Maintenance::whereDate('created_at', '=', date('Y-m-d'))
        //     ->where('hardware_id', '=', $request->hardware)
        //     ->first();
        // return response()->json([
        //     'maintenance' => $maintenance,
        //     'mtbf' => $mtbf,
        //     'mttr' => $mttr,
        // ]);
        // Status Belum Ada Data
        //* Mengisi Data MTBF dan MTTR lalu membuat MTBF dan MTTR lagi ditanggal sama dengan hari ini => Solved
        //* Mengisi Data MTBF dan Membuat MTBF lagi ditanggal sama dengan hari ini => Solved
        //* Mengisi Data MTTR dan Membuat MTTR lagi ditanggal sama dengan hari ini => Solved
        //* Mengisi Data MTBF dan Membuat MTTR lagi ditanggal sama dengan hari ini => Solved
        //* Mengisi Data MTTR dan Membuat MTBF lagi ditanggal sama dengan hari ini => Solved
        // Sudah Ada Data MTBF hari kemarin
        //* Mengisi Data MTBF dan MTTR lalu membuat MTBF dan MTTR lagi ditanggal sama dengan hari ini => Solved
        //* Mengisi Data MTBF dan Membuat MTBF lagi ditanggal sama dengan hari ini => Solved
        //* Mengisi Data MTTR dan Membuat MTTR lagi ditanggal sama dengan hari ini => Solved
        // Sudah Ada Data MTTR hari kemarin 
        //* Mengisi Data MTBF dan MTTR lalu membuat MTBF dan MTTR lagi ditanggal sama dengan hari ini => Solved
        //* Mengisi Data MTBF dan Membuat MTBF lagi ditanggal sama dengan hari ini => Solved
        //* Mengisi Data MTTR dan Membuat MTTR lagi ditanggal sama dengan hari ini => Solved
        // Sudah Ada Data MTBF dan MTTR hari kemarin
        //* Mengisi Data MTBF dan MTTR lalu membuat MTBF dan MTTR lagi ditanggal sama dengan hari ini => Solved
        //* Mengisi Data MTBF dan Membuat MTBF lagi ditanggal sama dengan hari ini => Solved
        //* Mengisi Data MTTR dan Membuat MTTR lagi ditanggal sama dengan hari ini => Solved
        // if ($mtbf != null && $mttr != null) {
        //     return response()->json([
        //         'error' => 'Data Sudah Ada untuk tanggal dan hardware ini!'
        //     ], 400);
        // } elseif ($mtbf && $mttr != null) {
        //     return response()->json([
        //         'error' => 'Data MTBF untuk hardware ini sudah ada untuk tanggal sekarang!'
        //     ], 400);
        // } elseif ($mttr && $mtbf != null) {
        //     return response()->json([
        //         'error' => 'Data MTTR untuk hardware ini sudah ada untuk tanggal sekarang!'
        //     ], 400);
        // }
        //* Create All MTBF and MTTR => SOLVED
        //* Create MTBF and then MTTR => SOLVED
        //* Create MTTR and then MTBF => SOLVED
        //* Delete MTBF and Create MTTR => SOLVED
        //* Delete MTTR and Create MTBF => SOLVED
        // Stored Data
        try {
            // if ($mttrData["mttr"] == 0) {
            //     // Stored Data MTBF
            //     $mtbf = MTBF::create([
            //         'working' => $mtbfData["total_work"],
            //         'breakdown' => $mtbfData["breakdown"],
            //         'total' => $mtbfData["mtbf"],
            //         'time' => $mtbfData["time_breakdown"],
            //     ]);

            //     if ($maintenance) {
            //         $maintenance->mtbf_id = $mtbf->id;
            //         $maintenance->availability = $this->calculatedAvailibility(
            //             $mtbf->total,
            //             $maintenance->mttr->total
            //         );
            //         $maintenance->save();
            //     } else {
            //         $mt_dt = MaintenanceDetail::create([
            //             'code' => $request->code
            //         ]);
            //         $maintenance = Maintenance::create([
            //             'mtbf_id' => $mtbf->id,
            //             'hardware_id' => $request->hardware,
            //             'mt_id' => $mt_dt->id,
            //             'availability' => $this->calculatedAvailibility($mtbf->total ?? 0, $mttr->total ?? 0),
            //         ]);
            //     }
            // } elseif ($mttr == null && $request->total_work == null) {
            //     // Create Data MTTR
            //     $mttr = MTTR::create([
            //         'maintenance_time' => $mttrData["maintenance_time"],
            //         'time' => $mttrData["start_time_maintenance"],
            //         'repairs' => count($mttrData["maintenance_time"]),
            //         'total' => $mttrData["mttr"]
            //     ]);

            //     if ($maintenance) {
            //         $maintenance->mttr_id = $mttr->id;
            //         $maintenance->availability = $this->calculatedAvailibility(
            //             $maintenance->mtbf->total,
            //             $mttr->total
            //         );
            //         $maintenance->save();
            //     } else {
            //         $mt_dt = MaintenanceDetail::create([
            //             'code' => $request->code
            //         ]);
            //         $maintenance = Maintenance::create([
            //             'mttr_id' => $mttr->id,
            //             'hardware_id' => $request->hardware,
            //             'mt_id' => $mt_dt->id,
            //             'availability' => $this->calculatedAvailibility($mtbf->total ?? 0, $mttr->total ?? 0),
            //         ]);
            //     }
            // } elseif ($mtbf == null && $mttr == null) {
            // Create ALL Data MTBF & MTTR   
            $mtbf = MTBF::create([
                'working' => $mtbfData["total_work"],
                'breakdown' => $mtbfData["breakdown"],
                'total' => $mtbfData["mtbf"],
                'time' => $mtbfData["time_breakdown"],
            ]);
            $mttr = MTTR::create([
                'maintenance_time' => $mttrData["maintenance_time"],
                'time' => $mttrData["start_time_maintenance"],
                'repairs' => count($mttrData["maintenance_time"]),
                'total' => $mttrData["mttr"]
            ]);

            $mt_dt = MaintenanceDetail::create([
                'code' => $request->code
            ]);
            $maintenance = Maintenance::create([
                'mtbf_id' => $mtbf->id,
                'mttr_id' => $mttr->id,
                'hardware_id' => $request->hardware,
                'mt_id' => $mt_dt->id,
                'availability' => $this->calculatedAvailibility($mtbf->total, $mttr->total),
                'type' => $request->type,
                'notes' => $request->notes
            ]);
            // } else {
            //     return response()->json([
            //         'status' => 'error',
            //         'error' => 'Data Tidak Bisa Diupdate Hapus Terlebih Dahulu'
            //     ], 400);
            // }

            if ($dependency->isNotEmpty()) {
                $availibilityData = [];
                foreach ($dependency as $key) {
                    $maintenanceID = MaintenanceDetail::find($key->values()[1])->maintenance->id;
                    Dependency::create([
                        'hardware_id' => $request->hardware,
                        'child_id' => $maintenanceID,
                        'parent_mt_id' => $maintenance->id
                    ]);
                    array_push($availibilityData, $maintenanceID);
                }
                array_push($availibilityData, $maintenance->availability);
                // Calculate Avalibility Per Items                
                $maintenance->availability = array_sum($availibilityData);
                $maintenance->save();
            }

            return response()->json([
                'status' => 'success',
                'data' => 'Data berhasil disimpan!'
            ]);
        } catch (Exception $e) {
            Log::debug($e->getMessage() . ' ' . $e->getLine());
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        // Get Availibility Statistics Per Month
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function report(Request $request)
    {
        //
    }

    public function recycle()
    {
        //
    }

    public function restore($id)
    {
        //
    }

    public function delete($id)
    {
        //
    }

    public function deleteAll()
    {
        //
    }

    function getRandomCode()
    {
        $code = 'MT' . rand(100, 999) . rand(100, 999) . substr(date('y'), -2);
        $check = MaintenanceDetail::where('code', $code)->first();

        if ($check == null) {
            return $code;
        } else {
            if ($check) {
                $this->getRandomCode();
            } else {
                return $code;
            }
        }
    }

    function getStatistics($table, $column)
    {
        $year = Carbon::now()->format('Y');
        $data = DB::table($table)
            // monthname for name month
            ->selectRaw('year(created_at) as year, month(created_at) as month, sum(' . $column . ') as total')
            ->whereYear('created_at', $year)
            ->groupBy('year', 'month')
            ->orderByRaw('min(created_at) desc')
            ->pluck('total', 'month')
            ->toArray();

        $dataArr = [];
        for ($i = 1; $i <= 12; $i++) {
            if (isset($data[$i])) {
                $dataArr[$i] = (float)$data[$i];
            } else {
                $dataArr[$i] = (float)0;
            }
        }

        return json_encode(array_values($dataArr));
    }

    function getData($month, $year)
    {
        $maintenance = Maintenance::with('detail', 'mtbf', 'mttr')
            ->where(DB::raw('YEAR(created_at)'), '=', $year)
            ->where(DB::raw('MONTH(created_at)'), '=', $month)
            ->get();

        return $maintenance;
    }

    function getDataPerMonth()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $uptime = $mtbf = $mttr = [];
        $maintenance = $this->getData($month, $year);

        foreach ($maintenance as $key => $value) {
            $uptime[] = $value->detail->code;
            $mtbf[] = $value->mtbf->total;
            $mttr[] = $value->mttr->total;
        }
    }

    function getMaintenance(Request $req)
    {
        $data['maintenance'] = Maintenance::with('detail')
            ->where("hardware_id", $req->hardware_id)
            ->get()->pluck('detail');
        return response()->json([
            'status' => 'success',
            'data' => $data['maintenance'],
        ]);
    }

    function addAdditional($count)
    {
        $data = '<div class="card" id="mycard-dimiss' . $count . '"><div class="card-header">';
        $data .= '<h4>Hardware Ketergantungan</h4><div class="card-header-action">';
        $data .= '<a data-dismiss="#mycard-dimiss' . $count . '" class="btn btn-icon btn-danger" href="#">';
        $data .= '<i class="fas fa-times"></i></a></div></div><div class="card-body"> <div class="row">';
        $data .= '<div class="col"> <div class="form-group"> <div class="d-block">      ';
        $data .= '<label class="control-label">Hardware<code>*</code></label></div>';
        $data .= '<select class="form-control select2 ajax" onchange="getMaintenance(this)" id="hardware_' . $count . '" name="hardware_' . $count . '" required>';
        foreach (Hardware::with('type.brand')->get() as $h) {
            $data .= '<option value="' . $h->id . '">' . $h->name . ' | ' . $h->type->name . ' | ' . $h->type->brand->name . '</option>';
        };
        $data .= ' </select> </div></div><div class="col"> <div class="form-group"> <div class="d-block">';
        $data .= '<label class="control-label">Kode Maintenance<code>*</code></label> </div>';
        $data .= '<select class="select2 ajax" name="maintenance_' . $count . '" id="maintenance_' . $count . '" required> </select> </div></div></div></div></div>';
        return $data;
    }
}