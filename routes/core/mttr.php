<?php

use App\Http\Controllers\Core\MTTRController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MTTR Routes
|--------------------------------------------------------------------------
|
| Here is where you can register mttr routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "mttr" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'data'], function () {
    Route::resource('mttr', MTTRController::class);
});

Route::group(['prefix' => 'temp'], function () {
    Route::get('/mttr', [MTTRController::class, 'recycle'])
        ->name('mttr.recycle');
    Route::group(['prefix' => 'mttr'], function () {
        Route::get('/restore/{id}', [MTTRController::class, 'restore'])
            ->name('mttr.restore');;
        Route::delete('/delete/{id}', [MTTRController::class, 'delete']);
        Route::delete('/delete-all', [MTTRController::class, 'deleteAll']);
    });
});

Route::group(['prefix' => 'report'], function () {
    Route::get('/mttr', [MTTRController::class, 'report'])
        ->name('mttr.report');
});