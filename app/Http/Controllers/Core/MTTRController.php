<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Models\Maintenance;
use App\Models\MTTR;
use App\Models\Template\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class MTTRController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MainController $MainController)
    {
        $this->middleware('auth');
        $this->MainController = $MainController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function calculated($maintenanceTime)
    {
        $maintenanceTotal = 0;
        $repairs = count($maintenanceTime);
        foreach ($maintenanceTime as $key) {
            $maintenanceTotal += $key;
        }
        return $maintenanceTotal / $repairs;
    }

    public function calculatedAvailibility($mtbf, $mttr)
    {
        $availibility = $mtbf / ($mtbf + $mttr) * 100;
        return number_format($availibility, 2, '.', '');
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Maintenance::with('detail', 'mttr')->get();
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
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a onclick="del(' . $row->id . ')" class="btn btn-icon btn-danger btn-block m-1"';
                    $actionBtn .= 'style="cursor:pointer;color:white"><i class="fas fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.backend.core.mttr.indexMTTR');
    }

    public function create($maintenanceTime, $startTime)
    {
        return  [
            'maintenance_time' => $maintenanceTime,
            'mttr' => $this->calculated($maintenanceTime),
            'start_time_maintenance' => $startTime,
        ];
    }

    public function store($maintenance, $total)
    {
        //
    }

    public function show($id)
    {
        // Get MTTR Statistics Per Month
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
        // Initialize Variable
        $mttr = MTTR::find($id);
        $maintenance = Maintenance::find($mttr->maintenance->id);

        // Changes Data Maintenance
        $maintenance->mttr_id = null;
        $maintenance->availability = 0;
        $maintenance->save();

        // Deleted
        $mttr->delete();

        return Response::json(['status' => 'success']);
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
}