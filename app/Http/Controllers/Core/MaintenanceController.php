<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Models\MaintenanceDetail;
use App\Models\MTBF;
use App\Models\MTTR;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

    public function index()
    {
        return view('pages.backend.data.maintance.indexMaintenance');
    }

    public function create()
    {
        $code = $this->getRandomCode();
        return view('pages.backend.data.maintance.createMaintenance', [
            'code' => $code
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
        $mtbf = $this->mtbf->createMTBF($request->total_work, $request->time_damaged, $request->start_damaged);
        $mttr = $this->mttr->createMTTR($request->total_maintenance, $request->start_maintenance);


        dd($mtbf);
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
}