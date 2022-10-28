<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChangeEmailController;
use App\Http\Controllers\AddEmailController;
use App\Http\Controllers\AddNumberController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HiddenAccountController;
use App\Http\Controllers\PostController;


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
Route::delete('users-delete/{id?}', [HiddenAccountController::class, 'destroy']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('change-number', [ProfileController::class, 'addNumber']);
    Route::post('update-number', [ProfileController::class, 'UpdateNumber']);

    Route::post('change-email', [ChangeEmailController::class, 'addEmail']);
    Route::post('update-email', [ChangeEmailController::class, 'UpdateEmail']);

    Route::post('send-email', [AddEmailController::class, 'sendemail']);
    Route::post('add-email', [AddEmailController::class, 'addemail']);

    Route::post('send-number', [AddNumberController::class, 'sendnumber']);
    Route::post('add-number', [AddNumberController::class, 'addnumber']);

    Route::post('change-password', [ChangePasswordController::class, 'ChangePassword']);
    Route::post('change-username', [ChangePasswordController::class, 'ChangeUsername']);

    Route::post('hidden-account', [HiddenAccountController::class, 'hiddenAccount']);
    Route::post('post', [PostController::class, 'store']);

});





