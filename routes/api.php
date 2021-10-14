<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomAPIController;
use App\Http\Controllers\BookingAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Room
 */
/* list */
Route::get('/room/list', [RoomAPIController::class, 'actionList'])->name('room-api-list');
/* one */
Route::get('/room/{id}', [RoomAPIController::class, 'actionOne'])->name('room-api-one');
/* create */
Route::post('/room', [RoomAPIController::class, 'actionCreate'])->name('room-api-create');
/* delete */
Route::delete('/room/{id}', [RoomAPIController::class, 'actionDelete'])->name('room-api-delete');
/* test */
Route::any('/room/test', [RoomAPIController::class, 'actionTest'])->name('room-api-delete');

/*
 * Booking
 */
/* list */
Route::any('/booking/list', [BookingAPIController::class, 'actionList'])->name('booking-api-list');
/* create */
Route::any('/booking/create', [BookingAPIController::class, 'actionCreate'])->name('booking-api-create');
/* delete */
Route::any('/booking/delete', [BookingAPIController::class, 'actionDelete'])->name('booking-api-delete');
