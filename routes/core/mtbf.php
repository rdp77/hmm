<?php

use App\Http\Controllers\Core\MTBFController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MTBF Routes
|--------------------------------------------------------------------------
|
| Here is where you can register mtbf routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "mtbf" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'data'], function () {
    Route::resource('mtbf', MTBFController::class);
});

Route::group(['prefix' => 'temp'], function () {
    Route::get('/mtbf', [MTBFController::class, 'recycle'])
        ->name('mtbf.recycle');
    Route::group(['prefix' => 'mtbf'], function () {
        Route::get('/restore/{id}', [MTBFController::class, 'restore'])
            ->name('mtbf.restore');;
        Route::delete('/delete/{id}', [MTBFController::class, 'delete']);
        Route::delete('/delete-all', [MTBFController::class, 'deleteAll']);
    });
});

Route::group(['prefix' => 'report'], function () {
    Route::get('/mtbf', [MTBFController::class, 'report'])
        ->name('mtbf.report');
});