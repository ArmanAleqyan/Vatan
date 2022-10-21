<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('registration', [RegisterController::class, 'store'])->name('registration');
Route::post('login', [LoginController::class, 'store'])->name('login');
Route::post('verify', [LoginController::class, 'verify'])->name('verify');
Route::post('/code-sending', [ForgotController::class, 'send'])->name('code-sending');
Route::post('/restore-password', [ForgotController::class, 'CodeSend']);
Route::post('/update-password', [ForgotController::class, 'updatePassword']);



