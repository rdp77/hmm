<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Models\Hardware;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use App\Models\MTBF;
use App\Models\MTTR;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
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
                    return $row->mtbf->total . " Jam";
                })
                ->addColumn('mttr', function ($row) {
                    return $row->mttr->total . " Jam";
                })
                ->addColumn('date', function ($row) {
                    return Carbon::parse($row->created_at)->isoFormat('dddd, D-MMM-Y');
                })
                ->addColumn('availibility', function ($row) {
                    return $row->availibility . "%";
                })
                ->make(true);
        }

        return view('pages.backend.data.maintance.indexMaintenance');
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

    public function store(Request $request)
    {
        // Check Duplicate
        $mtbf = MTBF::whereDate('created_at', '=', date('Y-m-d'))->first();
        $mttr = MTTR::whereDate('created_at', '=', date('Y-m-d'))->first();
        if ($mtbf) {
            return response()->json(['error' => 'Data MTBF sudah ada untuk tanggal ini!'], 400);
        } elseif ($mttr) {
            return response()->json(['error' => 'Data MTTR sudah ada untuk tanggal ini!'], 400);
        }
        // Create Datas
        $mtbf = $this->mtbf->create($request->total_work, $request->breakdown, $request->time_breakdown);
        $mttr = $this->mttr->create($request->maintenance_time, $request->start_time);
        // Stored Data
        $mtbf = MTBF::create([
            'working' => $mtbf["total_work"],
            'breakdown' => $mtbf["breakdown"],
            'total' => $mtbf["mtbf"],
            'time' => $mtbf["time_breakdown"],
        ]);
        $mttr = MTTR::create([
            'maintenance_time' => $mttr["maintenance_time"],
            'time' => $mttr["start_time_maintenance"],
            'repairs' => count($mttr["maintenance_time"]),
            'total' => $mttr["mttr"]
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

    public function getStatistics()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $uptime = $mtbf = $mttr = [];
        $maintenance = $this->getData($month, $year);



        return dd($maintenance);
        // return [
        //     'uptime' => $uptime,
        //     'mtbf' => $mtbf,
        //     'mttr' => $mttr,
        // ];
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
}