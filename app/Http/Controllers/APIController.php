<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\MaintenanceController;
use App\Http\Controllers\Template\MainController;
use App\Models\Brands;
use App\Models\Hardware;
use App\Models\Maintenance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class APIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MainController $MainController, MaintenanceController $MaintenanceController)
    {
        $this->MainController = $MainController;
        $this->Maintenance = $MaintenanceController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function getCount()
    {
        $users = User::count();
        $hardware = Hardware::count();
        $brands = Brands::count();
        $log = Activity::count();

        return response()->json([
            'users' => $users,
            'hardware' => $hardware,
            'brands' => $brands,
            'log' => $log
        ]);
    }

    public function search($code)
    {
        $check = Hardware::where('code', $code)->first();

        if (!$check == null) {
            $url = Str::slug($check->code);
            return response()->json([
                'status' => 'success', 'data' => route('result', $url)
            ]);
        }

        return response()->json([
            'status' => 'error', 'data' => 'Data Hardware Tidak Ada'
        ]);
    }

    public function getStatistics()
    {
        return [
            'mtbf' => $this->Maintenance->getStatistics('mtbf', 'total'),
            'mttr' => $this->Maintenance->getStatistics('mttr', 'total'),
            'availibility' => $this->Maintenance->getStatistics('maintenance', 'availability')
        ];
    }

    public function getMaintenance()
    {
        $data = [];
        $maintenance = Maintenance::with('detail', 'mtbf', 'mttr')
            ->get();
        $data['total'] = count($maintenance);

        foreach ($maintenance as $row) {
            $data['data'][] = [
                'code' => $row->detail->code,
                'hardware_code' => $row->hardware->code,
                'brand' => $row->hardware->brand->name,
                'mtbf' => $row->mtbf->total . " Jam",
                'mttr' => $row->mttr->total . " Jam",
                'date' => Carbon::parse($row->created_at)->isoFormat('dddd, D-MMM-Y'),
                'availibility' => $row->availability . "%"
            ];
        }

        return $data;
    }
}