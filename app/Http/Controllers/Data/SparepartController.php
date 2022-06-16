<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Http\Requests\SparepartRequest;
use App\Models\Brands;
use App\Models\Spareparts;
use App\Models\Template\ActivityList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class SparepartController extends Controller
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
            $data = Spareparts::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('brand', function ($row) {
                    return $row->brand->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-icon btn-primary btn-block m-1"';
                    $actionBtn .= 'href="' . route('sparepart.edit', $row->id) . '"><i class="far fa-edit"></i></a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="btn btn-icon btn-danger btn-block m-1"';
                    $actionBtn .= 'style="cursor:pointer;color:white"><i class="fas fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'website'])
                ->make(true);
        }

        return view('pages.backend.data.hardware.sparepart.indexSparepart');
    }

    public function create()
    {
        $brand = Brands::all();
        return view('pages.backend.data.hardware.sparepart.createSparepart', [
            'brand' => $brand
        ]);
    }

    public function store(SparepartRequest $req)
    {
        $validated = $req->validated();
        $performedOn = Spareparts::create($validated);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(16),
            true,
            Spareparts::find($performedOn->id)
        );

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil membuat sparepart baru'
        ]);
    }

    public function edit($id)
    {
        $sparepart = Spareparts::find($id);
        $brand = Brands::all();
        return view('pages.backend.data.hardware.sparepart.updateSparepart', [
            'sparepart' => $sparepart,
            'brand' => $brand
        ]);
    }

    public function update($id, SparepartRequest $req)
    {
        Spareparts::where('id', $id)
            ->update($req->except('_token', '_method'));

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(17),
            true,
            Spareparts::find($id)
        );

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil mengubah sparepart'
        ]);
    }

    public function destroy(Request $req, $id)
    {
        $sparepart = Spareparts::find($id);

        Spareparts::destroy($id);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(18),
            true,
            $sparepart
        );

        return Response::json(['status' => 'success']);
    }

    public function recycle(Request $req)
    {
        if ($req->ajax()) {
            $data = Spareparts::onlyTrashed()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('brand', function ($row) {
                    return $row->brand->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button onclick="restore(' . $row->id . ')" class="btn btn btn-primary 
                btn-action mb-1 mt-1 mr-1">Kembalikan</button>';
                    $actionBtn .= '<button onclick="delRecycle(' . $row->id . ')" class="btn btn-danger 
                    btn-action mb-1 mt-1">Hapus</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'brand_id'])
                ->make(true);
        }
        return view('pages.backend.data.hardware.sparepart.recycleSparepart');
    }

    public function restore($id, Request $req)
    {
        Spareparts::onlyTrashed()
            ->where('id', $id)
            ->restore();

        $sparepart = Spareparts::find($id);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(19),
            true,
            $sparepart
        );

        return Response::json(['status' => 'success']);
    }

    public function delete($id, Request $req)
    {
        Spareparts::onlyTrashed()
            ->where('id', $id)
            ->forceDelete();

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(20),
            false
        );

        return Response::json(['status' => 'success']);
    }

    public function deleteAll(Request $req)
    {
        $sparepart = Spareparts::onlyTrashed()
            ->forceDelete();

        if ($sparepart == 0) {
            return Response::json([
                'status' => 'error',
                'data' => "Tidak ada data di recycle bin"
            ]);
        } else {
            $sparepart;
        }

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(21),
            false
        );

        return Response::json(['status' => 'success']);
    }

    protected function getStatus($type, $custom = false, $message = null)
    {
        return $custom ? $message : ActivityList::find($type)->name;
    }
}