<?php

use App\Http\Controllers\Data\BrandController;
use App\Http\Controllers\Data\HardwareController;
use App\Http\Controllers\Data\SparepartController;
use App\Http\Controllers\Data\TypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Hardware Routes
|--------------------------------------------------------------------------
|
| Here is where you can register hardware routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "hardware" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'data'], function () {
    Route::resources([
        'hardware' => HardwareController::class,
        'brand' => BrandController::class,
        'sparepart' => SparepartController::class,
        'type' => TypeController::class,
    ]);
});

Route::group(['prefix' => 'temp'], function () {
    Route::controller(HardwareController::class)->group(function () {
        Route::get('/hardware', 'recycle')
            ->name('hardware.recycle');
        Route::group(['prefix' => 'hardware'], function () {
            Route::get('/restore/{id}', 'restore')
                ->name('hardware.restore');
            Route::delete('/delete/{id}', 'delete');
            Route::delete('/delete-all', 'deleteAll');
        });
    });
    Route::controller(BrandController::class)->group(function () {
        Route::get('/brand', 'recycle')
            ->name('brand.recycle');
        Route::group(['prefix' => 'brand'], function () {
            Route::get('/restore/{id}', 'restore')
                ->name('brand.restore');
            Route::delete('/delete/{id}', 'delete');
            Route::delete('/delete-all', 'deleteAll');
        });
    });
    Route::controller(TypeController::class)->group(function () {
        Route::get('/type', 'recycle')
            ->name('type.recycle');
        Route::group(['prefix' => 'type'], function () {
            Route::get('/restore/{id}', 'restore')
                ->name('type.restore');
            Route::delete('/delete/{id}', 'delete');
            Route::delete('/delete-all', 'deleteAll');
        });
    });
    Route::controller(SparepartController::class)->group(function () {
        Route::get('/sparepart', 'recycle')
            ->name('sparepart.recycle');
        Route::group(['prefix' => 'sparepart'], function () {
            Route::get('/restore/{id}', 'restore')
                ->name('sparepart.restore');
            Route::delete('/delete/{id}', 'delete');
            Route::delete('/delete-all', 'deleteAll');
        });
    });
});