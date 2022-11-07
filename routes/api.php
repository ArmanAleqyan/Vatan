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
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\ReplyAnsverController;
use App\Http\Controllers\PostLikesController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\FamilyController;


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

    Route::post('comment', [CommentController::class, 'store']);
    Route::post('comment-reply', [CommentReplyController::class, 'store']);
    Route::post('comment-reply-answer', [ReplyAnsverController::class, 'store']);

    Route::post('post-likes', [PostLikesController::class, 'store']);
    Route::post('comment-likes', [PostLikesController::class, 'commentStore']);
    Route::post('comment-reply-likes', [PostLikesController::class, 'commentreplyStore']);
    Route::post('reply-answer-likes', [PostLikesController::class, 'replyanswerStore']);

    Route::get('add-friends', [FriendsController::class, 'index']);
    Route::post('add-friends', [FriendsController::class, 'store']);
    Route::post('confirm-request', [FriendsController::class, 'confirmRequest']);
    Route::post('cancel-request', [FriendsController::class, 'cancelRequest']);
    Route::post('delete-friend', [FriendsController::class, 'deleteFriend']);

    Route::post('send-family-request', [FamilyController::class, 'sendRequest']);
    Route::post('confirm-family-request', [FamilyController::class, 'confirmFamilyRequest']);
    Route::post('cancel-family-request', [FamilyController::class, 'cancelFamilyRequest']);
    Route::post('delete-family-request', [FamilyController::class, 'deleteFamily']);

});





