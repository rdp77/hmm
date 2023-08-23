<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Template\MainController;
use App\Models\Brands;
use App\Models\Hardware;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Spatie\Activitylog\Models\Activity;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\Facades\DNS2DFacade;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        MainController $MainController
    ) {
        $this->middleware('auth');
        $this->MainController = $MainController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $log = Activity::limit(7)
            ->orderBy('id', 'desc')
            ->get();
        $users = User::count();
        $hardware = Hardware::count();
        $brands = Brands::count();
        $logCount = Activity::where('causer_id', Auth::user()->id)
            ->count();
        $hardwareList = Type::with('brand')->get();

        return view('dashboard', [
            'log' => $log,
            'users' => $users,
            'hardware' => $hardware,
            'brands' => $brands,
            'logCount' => $logCount,
            'hardwareList' => $hardwareList,
        ]);
    }

    public function log(Request $req)
    {
        if ($req->ajax()) {
            $data = Activity::where('causer_id', Auth::user()->id)
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('added_at', function ($row) {
                    return date("d-M-Y H:m", strtotime($row->created_at));
                })
                ->addColumn('url', function ($row) {
                    return $row->getExtraProperty('url');
                })
                ->addColumn('ip', function ($row) {
                    return $row->getExtraProperty('ip');
                })
                ->addColumn('user_agent', function ($row) {
                    return $row->getExtraProperty('user_agent');
                })
                ->rawColumns(['added_at', 'ip', 'user_agent'])
                ->make(true);
        }
        return view('pages.backend.log.IndexLog');
    }

    public function print($id)
    {
        $hardware = Hardware::findOrFail($id);
        $name = 'hardware_' . $hardware->code . '.pdf';
        $barcode = DNS2DFacade::getBarcodeHTML($hardware->code ?? url('/'), 'QRCODE');
        $pdf = PDF::loadView('pages.print', compact('hardware', 'barcode'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->save(public_path($name));
        return view('pages.viewPrint', compact('name'));
    }
}