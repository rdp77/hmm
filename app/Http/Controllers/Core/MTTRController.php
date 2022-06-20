<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Models\MTTR;
use App\Models\Template\Log;
use Illuminate\Http\Request;

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

    public function calculated($total_maintenance)
    {
        $maintance = 0;
        $totalMaintenance = count($total_maintenance);
        foreach ($total_maintenance as $key) {
            $maintance += $key;
        }
        return $maintance / $totalMaintenance;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store($maintenance, $total)
    {
        MTTR::create([
            'maintenance_time' => $maintenance,
            'repairs' => count($maintenance),
            'total' => $total
        ]);

        return true;
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

    public function createMTTR($total_maintenance, $time_maintenance)
    {
        return  [
            'maintenance' => $total_maintenance,
            'mttr' => $this->calculated($total_maintenance),
            'time_maintenance' => $time_maintenance,
        ];
    }
}