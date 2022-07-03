<?php

use App\Http\Controllers\Core\MaintenanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Template\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Front End
Route::get('/', [FrontController::class, 'index']);
Route::get('/formula', [FrontController::class, 'formula'])
    ->name('formula');
Route::get('/search/{code}', [FrontController::class, 'search'])
    ->name('search');
Route::get('/result/{code}', [FrontController::class, 'result'])
    ->name('result');
Route::get('/data-maintenance/{code}', [FrontController::class, 'maintenance'])
    ->name('data.maintenance');
Route::get('/data-mtbf/{code}', [FrontController::class, 'mtbf'])
    ->name('data.mtbf');
Route::get('/data-mttr{code}', [FrontController::class, 'mttr'])
    ->name('data.mttr');

// Backend
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::resource('maintenance', MaintenanceController::class);
Route::get('/maintenance-statistics', [MaintenanceController::class, 'getStatistics'])
    ->name('maintenance.statistics');
Route::post('/get-maintenance', [MaintenanceController::class, 'getMaintenance'])
    ->name('maintenance.getMaintenance');
Route::get('/add-dependency/{count}', [MaintenanceController::class, 'addAdditional'])
    ->name('maintenance.addAdditional');
// Server Monitor
Route::get('/server-monitor', [DashboardController::class, 'serverMonitor'])
    ->name('dashboard.server-monitor');
Route::prefix('server-monitor')->group(function () {
    Route::get('refresh', [MainController::class, 'serverMonitorRefresh'])
        ->name('dashboard.server-monitor.refresh');
    Route::get('refresh-all', [MainController::class, 'serverMonitorRefreshAll'])
        ->name('dashboard.server-monitor.refreshAll');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/data/users.php';
require __DIR__ . '/data/activity.php';
require __DIR__ . '/data/hardware.php';
require __DIR__ . '/core/mtbf.php';
require __DIR__ . '/core/mttr.php';