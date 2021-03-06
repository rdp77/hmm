<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\MaintenanceController;
use App\Http\Controllers\Template\MainController;
use App\Models\Brands;
use App\Models\Hardware;
use App\Models\Maintenance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        return response()->json([
            'mtbf' => $this->calculatedStatistics('mtbf', 'total'),
            'mttr' => $this->calculatedStatistics('mttr', 'total'),
            'availibility' => $this->calculatedStatistics('maintenance', 'availability')
        ]);
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

    function calculatedStatistics($table, $column)
    {
        $year = Carbon::now()->format('Y');
        $data = DB::table($table)
            ->selectRaw('year(created_at) as year, month(created_at) as month, sum(' . $column . ') as total')
            ->whereYear('created_at', $year)
            ->groupBy('year', 'month')
            ->orderByRaw('min(created_at) desc')
            ->pluck('total', 'month')
            ->toArray();

        $dataArr = [];
        for ($i = 1; $i <= 12; $i++) {
            if (isset($data[$i])) {
                $total = (float)$data[$i];
            } else {
                $total = (float)0.0;
            }
            switch ($i) {
                case 1:
                    $tgl = 'Januari';
                    break;
                case 2:
                    $tgl = 'Februari';
                    break;
                case 3:
                    $tgl = 'Maret';
                    break;
                case 4:
                    $tgl = 'April';
                    break;
                case 5:
                    $tgl = 'Mei';
                    break;
                case 6:
                    $tgl = 'Juni';
                    break;
                case 7:
                    $tgl = 'Juli';
                    break;
                case 8:
                    $tgl = 'Agustus';
                    break;
                case 9:
                    $tgl = 'September';
                    break;
                case 10:
                    $tgl = 'Oktober';
                    break;
                case 11:
                    $tgl = 'November';
                    break;
                case 12:
                    $tgl = 'Desember';
                    break;
            }
            array_push($dataArr, ['nama' => $tgl, 'total' => $total]);
        }

        return $dataArr;
    }
}