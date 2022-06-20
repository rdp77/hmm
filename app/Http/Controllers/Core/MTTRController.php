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

    public function calculated($maintenanceTime)
    {
        $maintenanceTotal = 0;
        $repairs = count($maintenanceTime);
        foreach ($maintenanceTime as $key) {
            $maintenanceTotal += $key;
        }
        return $maintenanceTotal / $repairs;
    }

    public function index()
    {
        //
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