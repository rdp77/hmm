<?php

namespace App\Http\Controllers\Data;

use App\Enums\HardwareStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Template\MainController;
use App\Http\Requests\HardwareRequest;
use App\Models\Brands;
use App\Models\Hardware;
use App\Models\Template\ActivityList;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Milon\Barcode\Facades\DNS1DFacade;
use Milon\Barcode\Facades\DNS2DFacade;

class HardwareController extends Controller
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
            $data = Hardware::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status->value == 'baru') {
                        $status = '<span class="badge badge-success">';
                    } else if ($row->status->value == 'normal') {
                        $status = '<span class="badge badge-primary">';
                    } else {
                        $status = '<span class="badge badge-danger">';
                    }
                    $status .= Str::headline($row->status->value);
                    $status .= '</span>';
                    return $status;
                })
                ->addColumn('model', function ($row) {
                    return $row->type->name;
                })
                ->addColumn('brand', function ($row) {
                    return $row->type->brand->name;
                })
                ->addColumn('purchase_date', function ($row) {
                    if ($row->purchase_date == null) {
                        return '-';
                    } else {
                        return Carbon::parse($row->purchase_date)->isoFormat('dddd, D-MMM-Y');
                    }
                })
                ->addColumn('warranty_date', function ($row) {
                    if ($row->warranty_date == null) {
                        return '-';
                    } else {
                        return Carbon::parse($row->warranty_date)->isoFormat('dddd, D-MMM-Y');
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-icon btn-success btn-block m-1"';
                    $actionBtn .= 'href="' . route('print', $row->id) . '" target="_blank"><i class="fa-solid fa-barcode"></i></a>';
                    $actionBtn .= '<a class="btn btn-icon btn-primary btn-block m-1"';
                    $actionBtn .= 'href="' . route('hardware.edit', $row->id) . '"><i class="far fa-edit"></i></a>';
                    $actionBtn .= '<a onclick="del(' . $row->id . ')" class="btn btn-icon btn-danger btn-block m-1"';
                    $actionBtn .= 'style="cursor:pointer;color:white"><i class="fas fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'brand', 'purchase_date', 'warranty_date', 'status'])
                ->make(true);
        }

        return view('pages.backend.data.hardware.indexHardware');
    }

    public function create()
    {
        $status = HardwareStatusEnum::cases();
        $type = Type::with('brand')->get();
        $code = $this->getRandomCode();
        return view('pages.backend.data.hardware.createHardware', [
            'type' => $type,
            'code' => $code,
            'status' => $status
        ]);
    }

    public function store(HardwareRequest $req)
    {
        $purchaseDate = $req->purchase_date == null ? null :
            $this->MainController->ChangeMonthIdToEn($req->purchase_date);
        $warrantyDate = $req->warranty_date == null ? null :
            $this->MainController->ChangeMonthIdToEn($req->warranty_date);

        $performedOn = Hardware::create([
            'name' => $req->name,
            'code' => $req->code,
            'serial_number' => $req->serial_number,
            'model' => $req->model,
            'type_id' => $req->type_id,
            'description' => $req->description,
            'purchase_date' => $purchaseDate,
            'warranty_date' => $warrantyDate,
            'status' => $req->status
        ]);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(22),
            true,
            Hardware::find($performedOn->id)
        );

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil membuat hardware baru'
        ]);
    }

    public function edit($id)
    {
        $status = HardwareStatusEnum::cases();
        $hardware = Hardware::find($id);
        $type = Type::with('brand')->get();
        return view('pages.backend.data.hardware.updateHardware', [
            'hardware' => $hardware,
            'type' => $type,
            'status' => $status
        ]);
    }

    public function update($id, HardwareRequest $req)
    {
        $purchaseDate = $req->purchase_date == null ? null :
            $this->MainController->ChangeMonthIdToEn($req->purchase_date);
        $warrantyDate = $req->warranty_date == null ? null :
            $this->MainController->ChangeMonthIdToEn($req->warranty_date);

        Hardware::where('id', $id)
            ->update([
                'name' => $req->name,
                'serial_number' => $req->serial_number,
                'type_id' => $req->type_id,
                'description' => $req->description,
                'purchase_date' => $purchaseDate,
                'warranty_date' => $warrantyDate,
                'status' => $req->status
            ]);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(23),
            true,
            Hardware::find($id)
        );

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil mengubah hardware'
        ]);
    }

    public function destroy(Request $req, $id)
    {
        $hardware = Hardware::find($id);

        Hardware::destroy($id);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(24),
            true,
            $hardware
        );

        return Response::json(['status' => 'success']);
    }

    public function recycle(Request $req)
    {
        if ($req->ajax()) {
            $data = Hardware::onlyTrashed()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status->value == 'baru') {
                        $status = '<span class="badge badge-success">';
                    } else if ($row->status->value == 'normal') {
                        $status = '<span class="badge badge-primary">';
                    } else {
                        $status = '<span class="badge badge-danger">';
                    }
                    $status .= Str::headline($row->status->value);
                    $status .= '</span>';
                    return $status;
                })
                ->addColumn('model', function ($row) {
                    return $row->type->name;
                })
                ->addColumn('brand', function ($row) {
                    return $row->type->brand->name;
                })
                ->addColumn('purchase_date', function ($row) {
                    if ($row->purchase_date == null) {
                        return '-';
                    } else {
                        return Carbon::parse($row->purchase_date)->isoFormat('dddd, D-MMM-Y');
                    }
                })
                ->addColumn('warranty_date', function ($row) {
                    if ($row->warranty_date == null) {
                        return '-';
                    } else {
                        return Carbon::parse($row->warranty_date)->isoFormat('dddd, D-MMM-Y');
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button onclick="restore(' . $row->id . ')" class="btn btn btn-primary 
                btn-action mb-1 mt-1 mr-1">Kembalikan</button>';
                    $actionBtn .= '<button onclick="delRecycle(' . $row->id . ')" class="btn btn-danger 
                    btn-action mb-1 mt-1">Hapus</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'brand', 'purchase_date', 'warranty_date', 'status'])
                ->make(true);
        }
        return view('pages.backend.data.hardware.recycleHardware');
    }

    public function restore($id, Request $req)
    {
        Hardware::onlyTrashed()
            ->where('id', $id)
            ->restore();

        $hardware = Hardware::find($id);

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(25),
            true,
            $hardware
        );

        return Response::json(['status' => 'success']);
    }

    public function delete($id, Request $req)
    {
        Hardware::onlyTrashed()
            ->where('id', $id)
            ->forceDelete();

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(26),
            false
        );

        return Response::json(['status' => 'success']);
    }

    public function deleteAll(Request $req)
    {
        $hardware = Hardware::onlyTrashed()
            ->forceDelete();

        if ($hardware == 0) {
            return Response::json([
                'status' => 'error',
                'data' => "Tidak ada data di recycle bin"
            ]);
        } else {
            $hardware;
        }

        // Create Log
        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            $this->getStatus(27),
            false
        );

        return Response::json(['status' => 'success']);
    }

    protected function getStatus($type, $custom = false, $message = null)
    {
        return $custom ? $message : ActivityList::find($type)->name;
    }

    function getRandomCode()
    {
        $code = 'HW' . rand(100, 999) . rand(100, 999) . substr(date('y'), -2);
        $check = Hardware::where('code', $code)->first();

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

    public function show($id)
    {
        $hardware = Hardware::find($id);
        $barcode = DNS2DFacade::getBarcodeHTML($hardware->code, 'QRCODE');
        $serial_number = DNS1DFacade::getBarcodeHTML($hardware->serial_number, 'C128');

        return view('pages.backend.data.hardware.showHardware', [
            'hardware' => $hardware,
            'barcode' => $barcode,
            'serial_number' => $serial_number
        ]);
    }
}