<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\MTBF;
use App\Models\MTTR;
use App\Models\Template\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class MTBFController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function calculated($totalWork, $totalBreakdown, $numberOfBreakdown)
    {
        // Hours
        return ($totalWork - $totalBreakdown) / $numberOfBreakdown;
    }

    public function calculatedAvailibility($mtbf, $mttr)
    {
        if ($mtbf == 0 && $mttr == 0) {
            return 0;
        } else {
            $availibility = $mtbf / ($mtbf + $mttr) * 100;
            return number_format($availibility, 2, '.', '');
        }
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Maintenance::with('detail', 'mtbf')->whereHas('mtbf', function ($query) {
                $query->where('mtbf_id', '!=', null);
            })->get();
            // when null []
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
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a onclick="del(' . $row->mtbf->id . ')" class="btn btn-icon btn-danger btn-block m-1"';
                    $actionBtn .= 'style="cursor:pointer;color:white"><i class="fas fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.backend.core.mtbf.indexMTBF');
    }

    public function create($totalWork, $breakdown, $timeBreakdown)
    {
        $totalBreakdown = 0;
        $numberBreakdown = count($breakdown);
        foreach ($breakdown as $key) {
            $totalBreakdown += $key;
        }
        return [
            'total_work' => $totalWork,
            'breakdown' => $breakdown,
            'number_breakdown' => $numberBreakdown,
            'total_breakdown' => $totalBreakdown,
            'time_breakdown' => $timeBreakdown,
            'mtbf' => $this->calculated($totalWork, $totalBreakdown, $numberBreakdown)
        ];
    }

    public function store($workingTime, $breakdown, $total)
    {
        //
    }

    public function show($id)
    {
        // Get MTBF Statistics Per Month        
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
        $mtbf = MTBF::find($id);
        $maintenance = Maintenance::find($mtbf->maintenance->id);

        // Changes Data Maintenance
        $maintenance->mtbf_id = null;
        $maintenance->availability = $this->calculatedAvailibility(
            0,
            $maintenance->mttr == null ? 0 : $maintenance->mttr
        );
        $maintenance->save();
        if ($maintenance->mtbf == null && $maintenance->mttr == null) {
            $maintenance->delete();
        }
        // Deleted
        $mtbf->delete();

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