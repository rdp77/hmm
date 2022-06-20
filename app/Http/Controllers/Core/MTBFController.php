<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Models\MTBF;
use App\Models\MTTR;
use App\Models\Template\Log;
use Illuminate\Http\Request;

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

    public function calculated($total_work, $breakdown_time, $total_breakdown_time)
    {
        // Hours
        return ($total_work - $breakdown_time) / $total_breakdown_time;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store($workingTime, $breakdown, $total)
    {
        MTBF::create([
            'working' => $workingTime,
            'breakdown' => $breakdown,
            'total' => $total,
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

    public function createMTBF($total_work, $time_damaged, $start_damaged)
    {
        $valueDamaged = 0;
        $totalDamaged = count($time_damaged);
        foreach ($time_damaged as $key) {
            $valueDamaged += $key;
        }
        return [
            'total_work' => $total_work,
            'damaged' => $time_damaged,
            'total_damaged' => $totalDamaged,
            'total_value_damaged' => $valueDamaged,
            'time_damaged' => $start_damaged,
            'mtbf' => $this->calculated($total_work, $valueDamaged, $totalDamaged)
        ];
    }
}