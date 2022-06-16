<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Http\Requests\BrandsRequest;
use App\Models\Brands;
use App\Models\Template\ActivityList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
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

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Brands::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('website', function ($row) {
                    $link = '<a href="http://' . $row->website . '" target="_blank">' . $row->website . '</a>';
                    return $link;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-icon btn-primary btn-block m-1"';
                    $actionBtn .= 'href="' . route('brand.edit', $row->id) . '"><i class="far fa-edit"></i></a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="btn btn-icon btn-danger btn-block m-1"';
                    $actionBtn .= 'style="cursor:pointer;color:white"><i class="fas fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'website'])
                ->make(true);
        }

        return view('pages.backend.data.hardware.brand.indexBrand');
    }

    public function create()
    {
        return view('pages.backend.data.hardware.brand.createBrand');
    }

    public function store(BrandsRequest $req)
    {
        $validated = $req->validated();
        $performedOn = Brands::create($validated);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(10),
            true,
            Brands::find($performedOn->id)
        );

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil membuat brand baru'
        ]);
    }

    public function edit($id)
    {
        $brand = Brands::find($id);
        return view('pages.backend.data.hardware.brand.updateBrand', [
            'brand' => $brand
        ]);
    }

    public function update($id, BrandsRequest $req)
    {
        Brands::where('id', $id)
            ->update($req->except('_token', '_method'));

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(11),
            true,
            Brands::find($id)
        );

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil mengubah brand'
        ]);
    }

    public function destroy(Request $req, $id)
    {
        $brand = Brands::find($id);

        Brands::destroy($id);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(12),
            true,
            $brand
        );

        return Response::json(['status' => 'success']);
    }

    public function recycle(Request $req)
    {
        if ($req->ajax()) {
            $data = Brands::onlyTrashed()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('website', function ($row) {
                    $link = '<a href="http://' . $row->website . '" target="_blank">' . $row->website . '</a>';
                    return $link;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button onclick="restore(' . $row->id . ')" class="btn btn btn-primary 
                btn-action mb-1 mt-1 mr-1">Kembalikan</button>';
                    $actionBtn .= '<button onclick="delRecycle(' . $row->id . ')" class="btn btn-danger 
                    btn-action mb-1 mt-1">Hapus</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'website'])
                ->make(true);
        }
        return view('pages.backend.data.hardware.brand.recycleBrand');
    }

    public function restore($id, Request $req)
    {
        Brands::onlyTrashed()
            ->where('id', $id)
            ->restore();

        $brand = Brands::find($id);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(13),
            true,
            $brand
        );

        return Response::json(['status' => 'success']);
    }

    public function delete($id, Request $req)
    {
        Brands::onlyTrashed()
            ->where('id', $id)
            ->forceDelete();

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(14),
            false
        );

        return Response::json(['status' => 'success']);
    }

    public function deleteAll(Request $req)
    {
        $brand = Brands::onlyTrashed()
            ->forceDelete();

        if ($brand == 0) {
            return Response::json([
                'status' => 'error',
                'data' => "Tidak ada data di recycle bin"
            ]);
        } else {
            $brand;
        }

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(15),
            false
        );

        return Response::json(['status' => 'success']);
    }

    protected function getStatus($type, $custom = false, $message = null)
    {
        return $custom ? $message : ActivityList::find($type)->name;
    }
}