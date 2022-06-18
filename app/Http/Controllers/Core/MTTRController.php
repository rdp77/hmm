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

    public function calculate()
    {
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
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

    public function createMTTR($total_maintenance, $start_maintenance)
    {
        return  [
            'total_maintenance' => $total_maintenance,
            'total' => count($total_maintenance),
            'time_maintenance' => $start_maintenance,
        ];
    }

    public function checkDuplicate()
    {
        $check = MTTR::whereDate('created_at', '=', date('Y-m-d'))->first();
        if ($check) {
            return true;
        } else {
            return false;
        }
    }
}