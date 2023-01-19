<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\Admin\ChatController;


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

Route::get('/', function () {
    return view('welcome');
});




Route::get('getAdminMessage', [ChatController::class, 'getAdminMessage'])->name('getAdminMessage');
Route::post('getAdminMessageJson', [ChatController::class, 'getAdminMessageJson'])->name('getAdminMessageJson');
Route::post('UpdateStatusChat', [ChatController::class, 'UpdateStatusChat'])->name('UpdateStatusChat');


Route::post('getRoomChat', [ChatController::class, 'getRoomChat'])->name('getRoomChat');
Route::post('SendAdminMessage', [ChatController::class, 'SendAdminMessage'])->name('SendAdminMessage');
