<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Http\Requests\MaintenanceRequest;
use App\Models\Hardware;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use App\Models\MTBF;
use App\Models\MTTR;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use LDAP\Result;
use Yajra\DataTables\DataTables;

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
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('code', function ($row) {
                    return $row->detail->code;
                })
                ->addColumn('hardware_code', function ($row) {
                    return $row->hardware->code;
                })
                ->addColumn('brand', function ($row) {
                    return $row->hardware->brand->name;
                })
                ->addColumn('mtbf', function ($row) {
                    $mtbf = $row->mtbf->total ?? 0;
                    return  $mtbf . " Jam";
                })
                ->addColumn('mttr', function ($row) {
                    $mttr = $row->mttr->total ?? 0;
                    return  $mttr . " Jam";
                })
                ->addColumn('date', function ($row) {
                    return Carbon::parse($row->created_at)->isoFormat('dddd, D-MMM-Y');
                })
                ->addColumn('availibility', function ($row) {
                    return $row->availability . "%";
                })
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
        $hardware = Hardware::with('brand')->get();
        return view('pages.backend.data.maintance.createMaintenance', [
            'code' => $code,
            'hardware' => $hardware,
        ]);
    }

    public function store(MaintenanceRequest $request)
    {
        // Create Datas
        $mtbfData = $this->mtbf->create($request->total_work, $request->breakdown, $request->time_breakdown);
        $mttrData = $this->mttr->create($request->maintenance_time, $request->start_time);

        // Check Duplicate
        $mtbf = MTBF::whereDate('created_at', '=', date('Y-m-d'))->first();
        $mttr = MTTR::whereDate('created_at', '=', date('Y-m-d'))->first();
        $maintenance = Maintenance::whereDate('created_at', '=', date('Y-m-d'))->first();
        // return $maintenance ?? 0;

        if ($mtbf && $mttr && $maintenance) {
            return response()->json(['error' => 'Data Sudah Ada!'], 400);
        } elseif ($mtbf && $request->total_work != null) {
            return response()->json(['error' => 'Data MTBF sudah ada untuk tanggal ini!'], 400);
        } elseif ($mttr && $maintenance->mttr_id != null && $mttrData["mttr"] != 0) {
            return response()->json(['error' => 'Data MTTR sudah ada untuk tanggal ini!'], 400);
        }
        //* Create All MTBF and MTTR
        //* Create MTBF and then MTTR
        //* Create MTTR and then MTBF
        //* Delete and Create

        // Stored Data
        if ($request->total_work != null && $mttrData["mttr"] != 0) {
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
            Maintenance::create([
                'mtbf_id' => $mtbf->id,
                'mttr_id' => $mttr->id,
                'hardware_id' => $request->hardware,
                'mt_id' => $mt_dt->id,
                'availability' => $this->calculatedAvailibility($mtbf->total, $mttr->total),
            ]);
        } else if ($request->total_work != null) {
            // Data MTBF
            // if ($mtbf) {
            //     // Update Data MTBF
            //     $mtbf->working = $mtbfData["total_work"];
            //     $mtbf->breakdown = $mtbfData["breakdown"];
            //     $mtbf->total = $mtbfData["mtbf"];
            //     $mtbf->time = $mtbfData["time_breakdown"];
            //     $mtbf->save();
            //     // Check Data Maintenance
            // } else {
            //     // Create Data MTBF
            //     $mtbf = MTBF::create([
            //         'working' => $mtbfData["total_work"],
            //         'breakdown' => $mtbfData["breakdown"],
            //         'total' => $mtbfData["mtbf"],
            //         'time' => $mtbfData["time_breakdown"],
            //     ]);
            // }
            $mtbf = MTBF::create([
                'working' => $mtbfData["total_work"],
                'breakdown' => $mtbfData["breakdown"],
                'total' => $mtbfData["mtbf"],
                'time' => $mtbfData["time_breakdown"],
            ]);

            if ($maintenance) {
                $maintenance->mtbf_id = $mtbf->id;
                $maintenance->availability = $this->calculatedAvailibility(
                    $mtbf->total,
                    $maintenance->mttr->total
                );
                $maintenance->save();
            } else {
                $mt_dt = MaintenanceDetail::create([
                    'code' => $request->code
                ]);
                Maintenance::create([
                    'mtbf_id' => $mtbf->id,
                    'hardware_id' => $request->hardware,
                    'mt_id' => $mt_dt->id,
                    'availability' => $this->calculatedAvailibility($mtbf->total ?? 0, $mttr->total ?? 0),
                ]);
            }
        } else {
            // Create Data MTTR
            $mttr = MTTR::create([
                'maintenance_time' => $mttrData["maintenance_time"],
                'time' => $mttrData["start_time_maintenance"],
                'repairs' => count($mttrData["maintenance_time"]),
                'total' => $mttrData["mttr"]
            ]);

            if ($maintenance) {
                $maintenance->mttr_id = $mttr->id;
                $maintenance->availability = $this->calculatedAvailibility(
                    $maintenance->mtbf->total,
                    $mttr->total
                );
                $maintenance->save();
            } else {
                $mt_dt = MaintenanceDetail::create([
                    'code' => $request->code
                ]);
                Maintenance::create([
                    'mttr_id' => $mttr->id,
                    'hardware_id' => $request->hardware,
                    'mt_id' => $mt_dt->id,
                    'availability' => $this->calculatedAvailibility($mtbf->total ?? 0, $mttr->total ?? 0),
                ]);
            }
        }





        // if ($request->total_work != null && count($request->maintenance_time) == 1) {

        //     return 'mtbf';
        // } elseif ($request->total_work == null) {

        //     return 'mttr';
        // } else {

        //     return 'kabeh';
        // }

        return response()->json([
            'status' => 'success',
            'data' => 'Data berhasil disimpan!'
        ]);
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
        // $data = DB::table($table)
        //     ->select('id', 'created_at', 'availability')
        //     ->get()
        //     ->groupBy(function ($date) {
        //         //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
        //         return Carbon::parse($date->created_at)->format('m'); // grouping by months
        //     });
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
                $dataArr[$i] = $data[$i];
            } else {
                $dataArr[$i] = 0;
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
}