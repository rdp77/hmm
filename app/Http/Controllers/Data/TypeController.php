<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Http\Requests\BrandsRequest;
use App\Models\Brands;
use App\Models\Template\ActivityList;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class TypeController extends Controller
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
            $data = Type::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('brand', function ($row) {
                    return $row->brand->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-icon btn-primary btn-block m-1"';
                    $actionBtn .= 'href="' . route('type.edit', $row->id) . '"><i class="far fa-edit"></i></a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="btn btn-icon btn-danger btn-block m-1"';
                    $actionBtn .= 'style="cursor:pointer;color:white"><i class="fas fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.backend.data.hardware.type.indexType');
    }

    public function create()
    {
        $brand = Brands::all();
        return view('pages.backend.data.hardware.type.createType', compact('brand'));
    }

    public function store(Request $req)
    {
        $performedOn = Type::create($req->all());

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(28),
            true,
            Type::find($performedOn->id)
        );

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil membuat tipe baru'
        ]);
    }

    public function edit($id)
    {
        $type = Type::find($id);
        $brand = Brands::all();
        return view('pages.backend.data.hardware.type.updateType', [
            'brand' => $brand,
            'type' => $type
        ]);
    }

    public function update($id, Request $req)
    {
        Type::where('id', $id)
            ->update($req->except('_token', '_method'));

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(29),
            true,
            Type::find($id)
        );

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil mengubah tipe'
        ]);
    }

    public function destroy(Request $req, $id)
    {
        $type = Type::find($id);

        Type::destroy($id);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(30),
            true,
            $type
        );

        return Response::json(['status' => 'success']);
    }

    public function recycle(Request $req)
    {
        if ($req->ajax()) {
            $data = Type::onlyTrashed()->get();
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
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.data.hardware.type.recycleType');
    }

    public function restore($id, Request $req)
    {
        Type::onlyTrashed()
            ->where('id', $id)
            ->restore();

        $type = Type::find($id);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(31),
            true,
            $type
        );

        return Response::json(['status' => 'success']);
    }

    public function delete($id, Request $req)
    {
        Type::onlyTrashed()
            ->where('id', $id)
            ->forceDelete();

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(32),
            false
        );

        return Response::json(['status' => 'success']);
    }

    public function deleteAll(Request $req)
    {
        $type = Type::onlyTrashed()
            ->forceDelete();

        if ($type == 0) {
            return Response::json([
                'status' => 'error',
                'data' => "Tidak ada data di recycle bin"
            ]);
        } else {
            $type;
        }

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(33),
            false
        );

        return Response::json(['status' => 'success']);
    }

    protected function getStatus($type, $custom = false, $message = null)
    {
        return $custom ? $message : ActivityList::find($type)->name;
    }
}