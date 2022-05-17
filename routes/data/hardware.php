<?php

use App\Http\Controllers\Data\BrandController;
use App\Http\Controllers\Data\HardwareController;
use App\Http\Controllers\Data\SparepartController;
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
    Route::resource('hardware', HardwareController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('sparepart', SparepartController::class);
});

Route::group(['prefix' => 'temp'], function () {
    // Hardware
    Route::get('/hardware', [HardwareController::class, 'recycle'])
        ->name('hardware.recycle');
    Route::group(['prefix' => 'hardware'], function () {
        Route::get('/restore/{id}', [HardwareController::class, 'restore'])
            ->name('hardware.restore');;
        Route::delete('/delete/{id}', [HardwareController::class, 'delete']);
        Route::delete('/delete-all', [HardwareController::class, 'deleteAll']);
    });
    // Brand
    Route::get('/brand', [BrandController::class, 'recycle'])
        ->name('brand.recycle');
    Route::group(['prefix' => 'brand'], function () {
        Route::get('/restore/{id}', [BrandController::class, 'restore'])
            ->name('brand.restore');;
        Route::delete('/delete/{id}', [BrandController::class, 'delete']);
        Route::delete('/delete-all', [BrandController::class, 'deleteAll']);
    });
    // Sparepart
    Route::get('/sparepart', [SparepartController::class, 'recycle'])
        ->name('sparepart.recycle');
    Route::group(['prefix' => 'sparepart'], function () {
        Route::get('/restore/{id}', [SparepartController::class, 'restore'])
            ->name('sparepart.restore');;
        Route::delete('/delete/{id}', [SparepartController::class, 'delete']);
        Route::delete('/delete-all', [SparepartController::class, 'deleteAll']);
    });
});