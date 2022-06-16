<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Template\MainController;
use App\Models\Hardware;
use App\Models\Template\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Sarfraznawaz2005\ServerMonitor\ServerMonitor;

class FrontController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('home');
    }

    public function search($code)
    {
        $check = Hardware::where('code', $code)->first();


        return $check ? response()->json(['status' => 'success', 'data' => $check]) :
            response()->json(['status' => 'error', 'data' => 'Data Hardware Tidak Ada'], 404);
    }

    public function show()
    {
    }

    public function formula()
    {
        return view('pages.backend.formula');
    }
}