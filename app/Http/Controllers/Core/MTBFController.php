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
        dd(Maintenance::with('code')->get());
        if ($req->ajax()) {
            $data = Maintenance::with('code')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status->value == 'baru') {
                        $status = '<span class="badge badge-success">';
                    } else if ($row->status->value == 'normal') {
                        $status = '<span class="badge badge-primary">';
                    } else {
                        $status = '<span class="badge badge-danger">';
                    }
                    $status .= Str::headline($row->status->value);
                    $status .= '</span>';
                    return $status;
                })
                ->addColumn('brand', function ($row) {
                    return $row->brand->name;
                })
                ->addColumn('purchase_date', function ($row) {
                    if ($row->purchase_date == null) {
                        return '-';
                    } else {
                        return Carbon::parse($row->purchase_date)->isoFormat('dddd, D-MMM-Y');
                    }
                })
                ->addColumn('warranty_date', function ($row) {
                    if ($row->warranty_date == null) {
                        return '-';
                    } else {
                        return Carbon::parse($row->warranty_date)->isoFormat('dddd, D-MMM-Y');
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-icon btn-success btn-block m-1"';
                    $actionBtn .= 'href="' . route('hardware.show', $row->id) . '"><i class="fa-solid fa-barcode"></i></a>';
                    $actionBtn .= '<a class="btn btn-icon btn-primary btn-block m-1"';
                    $actionBtn .= 'href="' . route('hardware.edit', $row->id) . '"><i class="far fa-edit"></i></a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="btn btn-icon btn-danger btn-block m-1"';
                    $actionBtn .= 'style="cursor:pointer;color:white"><i class="fas fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'brand', 'purchase_date', 'warranty_date', 'status'])
                ->make(true);
        }

        return view('pages.backend.data.hardware.indexHardware');
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
}