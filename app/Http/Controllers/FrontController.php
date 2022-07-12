<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\MaintenanceController;
use App\Http\Controllers\Template\MainController;
use App\Models\Dependency;
use App\Models\Hardware;
use App\Models\Maintenance;
use Illuminate\Support\Str;
use Milon\Barcode\Facades\DNS2DFacade;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FrontController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MainController $MainController, MaintenanceController $MaintenanceController)
    {
        $this->MainController = $MainController;
        $this->Maintenance = $MaintenanceController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('home');
    }

    public function search($code)
    {
        $check = Hardware::where('code', $code)->first();

        if (!$check == null) {
            $url = Str::slug($check->code);
            return response()->json([
                'status' => 'success', 'url' => route('result', $url)
            ]);
        }

        return response()->json([
            'status' => 'error', 'data' => 'Data Hardware Tidak Ada'
        ], 404);
    }

    public function result($code)
    {
        $hardware = Hardware::with('type', 'type.brand', 'type.brand.spareparts')->where('code', $code)
            ->first();
        $barcode = DNS2DFacade::getBarcodeHTML($hardware->code ?? url('/'), 'QRCODE');
        $dependency = Dependency::with(
            'maintenance',
            'maintenance.detail',
            'maintenance.mtbf',
            'maintenance.mttr',
            'maintenance.hardware'
        )
            ->where('hardware_id', $hardware->id)
            ->get();
        return $hardware ? view('result', compact('hardware', 'barcode', 'dependency')) : abort(404);
    }

    public function formula()
    {
        return view('pages.backend.formula');
    }

    public function maintenance(Request $req)
    {
        if ($req->ajax()) {
            $data = Maintenance::with('detail', 'mtbf', 'mttr')
                ->where('hardware_id', $req->code)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('code', function ($row) {
                    return $row->detail->code;
                })
                ->addColumn('brand', function ($row) {
                    return $row->hardware->type->brand->name;
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
                    $mtbf = $row->mtbf->total;
                    $mttr = $row->mttr->total;
                    $availibility = $this->Maintenance->calculatedAvailibility($mtbf, $mttr);
                    return $availibility . "%";
                })
                ->make(true);
        }
    }

    public function mtbf(Request $req)
    {
        if ($req->ajax()) {
            $data = Maintenance::with('detail', 'mtbf')
                ->whereHas('mtbf', function ($query) use ($req) {
                    $query->where('hardware_id', $req->code);
                })->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('code', function ($row) {
                    return $row->detail->code;
                })
                ->addColumn('brand', function ($row) {
                    return $row->hardware->type->brand->name;
                })
                ->addColumn('total_work', function ($row) {
                    return $row->mtbf->working . " Jam";
                })
                ->addColumn('total_breakdown', function ($row) {
                    $totalBreakdown = 0;
                    $breakdown = $row->mtbf->breakdown;
                    foreach ($breakdown as $key) {
                        $totalBreakdown += $key;
                    }
                    return $totalBreakdown . " Jam";
                })
                ->addColumn('breakdown', function ($row) {
                    $breakdown = [];
                    foreach ($row->mtbf->breakdown as $key) {
                        array_push($breakdown, " " . $key . " Jam");
                    }
                    return $breakdown;
                })
                ->addColumn('time_breakdown', function ($row) {
                    return $row->mtbf->time;
                })
                ->addColumn('total', function ($row) {
                    return $row->mtbf->total . " Jam";
                })
                ->make(true);
        }
    }

    public function mttr(Request $req)
    {
        if ($req->ajax()) {
            $data = Maintenance::with('detail', 'mttr')
                ->whereHas('mttr', function ($query) use ($req) {
                    $query->where('hardware_id', $req->code);
                })->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('code', function ($row) {
                    return $row->detail->code;
                })
                ->addColumn('brand', function ($row) {
                    return $row->hardware->type->brand->name;
                })
                ->addColumn('total_maintenance', function ($row) {
                    $maintenanceTotal = 0;
                    foreach ($row->mttr->maintenance_time as $key) {
                        $maintenanceTotal += $key;
                    }
                    return $maintenanceTotal . " Jam";
                })
                ->addColumn('time_maintenance', function ($row) {
                    $timeMaintenance = [];
                    foreach ($row->mttr->maintenance_time as $key) {
                        array_push($timeMaintenance, " " . $key . " Jam");
                    }
                    return $timeMaintenance;
                })
                ->addColumn('total_repair', function ($row) {
                    return $row->mttr->repairs;
                })
                ->addColumn('start_time', function ($row) {
                    return $row->mttr->time;
                })
                ->addColumn('total', function ($row) {
                    return $row->mttr->total . " Jam";
                })
                ->make(true);
        }
    }
}