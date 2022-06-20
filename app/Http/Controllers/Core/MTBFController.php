<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Models\Maintenance;
use App\Models\MTBF;
use App\Models\MTTR;
use App\Models\Template\Log;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MTBFController extends Controller
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

    public function calculated($totalWork, $totalBreakdown, $numberOfBreakdown)
    {
        // Hours
        return ($totalWork - $totalBreakdown) / $numberOfBreakdown;
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Maintenance::with('detail', 'mtbf')->get();
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
                    $actionBtn = '<a onclick="del(' . $row->id . ')" class="btn btn-icon btn-danger btn-block m-1"';
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
        //
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