<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Template\MainController;
use App\Models\Hardware;
use Illuminate\Support\Str;
use Milon\Barcode\Facades\DNS2DFacade;

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
        $url = Str::slug($check->code);

        return $check ? response()->json([
            'status' => 'success', 'url' => route('result', $url)
        ]) :
            response()->json(['status' => 'error', 'data' => 'Data Hardware Tidak Ada'], 404);
    }

    public function result($code)
    {
        $hardware = Hardware::with('brand', 'brand.spareparts')->where('code', $code)->first();
        $barcode = DNS2DFacade::getBarcodeHTML($hardware->code ?? url('/'), 'QRCODE');

        return $hardware ? view('result', compact('hardware', 'barcode')) : abort(404);
    }

    public function formula()
    {
        return view('pages.backend.formula');
    }
}