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
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupMembersController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Orders\BuyVatanServiceController;

use App\Http\Controllers\Api\VatanServiceController;

use App\Http\Middleware\NoActiveUser;


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
Route::delete('users-delete/{id?}/{pass}', [HiddenAccountController::class, 'destroy']);


Route::post('SendCodeTwo',[RegisterController::class, 'SendCodeTwo'])->name('SendCodeTwo');

Route::group(['middleware' => ['auth:api']], function () {

    Route::post('allpost', [PostController::class, 'allpost' ]);
    Route::get('singlePageUser/user_id={id}', [UserController::class,'singlePageUser']);

    Route::get('user-logout', [UserController::class, 'logout']);

    Route::post('check_auth_seen', [UserController::class,'check_auth_seen']);

    Route::get('group-data/{id?}', [GroupMembersController::class, 'index']);

//Admin

//    Moderator
    Route::post('admin-update-posts', [GroupController::class, 'updatePosts']);
    Route::post('admin-delete-posts', [GroupController::class, 'deletePosts']);
    Route::post('moderator-update-posts', [GroupController::class, 'ModeratotupdatePosts']);
    Route::post('moderator-delete-posts', [GroupController::class, 'ModeratordeletePosts']);
    Route::post('update-group-name', [GroupController::class, 'UpdateGroup']);
    Route::get('delete-group', [GroupController::class, 'deleteGroup']);
    Route::post('delete-moderator', [GroupController::class, 'DeleteModerator']);
    Route::post('GetUserFromInviteGroup', [GroupController::class, 'GetUserFromInviteGroup']);

//    Media
    Route::post('users-media', [MediaController::class, 'MyMedia']);
    Route::post('send-friend', [PostController::class, 'store']);
    Route::post('AllFile', [PostController::class, 'AllFile']);

//    Chat
    Route::post('/chat', [ChatController::class, 'store']);
    Route::get('/chat/{receiver_id}', [ChatController::class, 'getUsersData'])->name('chat');

    Route::get('user-data', [UserController::class, 'index']);
    Route::get('profile-user', [UserController::class, 'profile']);
    Route::get('some-user/{id?}', [UserController::class, 'OtherProfile']);
    Route::get('all-friends', [FriendsController::class, 'AllFriends']);
    Route::get('/rightsidechat', [ChatController::class, 'RightSiteUsers']);
    
    Route::get('AllService', [VatanServiceController::class, 'AllService']);

    Route::get('createOrder', [VatanServiceController::class, 'createOrder']);



    Route::post('UpdatePhotoAndBagraundPhoto', [UserController::class, 'UpdatePhotoAndBagraundPhoto']);
    Route::post('change-number', [ProfileController::class, 'addNumber']);
    Route::post('delete_avatar_and_back_round_photo', [ProfileController::class, 'delete_avatar_and_back_round_photo']);
    Route::post('update-number', [ProfileController::class, 'UpdateNumber']);
    Route::post('delete_avatar_and_backround_photo', [ProfileController::class, 'delete_avatar_and_backround_photo']);

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
    Route::get('post', [PostController::class, 'index']);
    Route::get('postSinglePage/post_id={id}', [PostController::class, 'postSinglePage']);
    Route::post('EditPost', [PostController::class, 'EditPost']);
    Route::get('DeletePost/post_id={id}', [PostController::class, 'DeletePost']);



    Route::post('comment', [CommentController::class, 'store']);
    Route::post('comment-reply', [CommentReplyController::class, 'store']);
    Route::post('comment-reply-answer', [ReplyAnsverController::class, 'store']);
    Route::get('all-notifications', [CommentController::class, 'index']);
    Route::post('viewed-notification', [CommentController::class, 'changeStatus']);
    Route::post('reply_viewed-notification', [CommentReplyController::class, 'changeStatus']);
    Route::post('replyanswer_viewed-notification', [ReplyAnsverController::class, 'changeStatus']);

    Route::post('post-likes', [PostLikesController::class, 'store']);
    Route::post('comment-likes', [PostLikesController::class, 'commentStore']);
    Route::post('comment-reply-likes', [PostLikesController::class, 'commentreplyStore']);
    Route::post('reply-answer-likes', [PostLikesController::class, 'replyanswerStore']);

    Route::get('add-friends', [FriendsController::class, 'index']);

    Route::post('add-friends', [FriendsController::class, 'store']);
    Route::post('deleteMyFriendRequest', [FriendsController::class, 'deleteMyFriendRequest']);
    Route::post('confirm-request', [FriendsController::class, 'confirmRequest']);
    Route::put('cancel-request', [FriendsController::class, 'cancelRequest']);
    Route::post('delete-friend', [FriendsController::class, 'deleteFriend']);
    Route::post('friends-birth', [FriendsController::class, 'friendsBirth']);
    Route::post('friends-posts', [PostController::class, 'friendsPosts']);



    Route::post('FriendsDay', [FriendsController::class, 'FriendsDay'])->name('FriendsDay');

//        Route::post('UpdatePhotoAndBagraundPhoto', [UserController::class,'UpdatePhotoAndBagraundPhoto']);

    Route::get('SinglePageholiday/{id}', [FriendsController::class, 'SinglePageholiday']);

    Route::post('send-family-request', [FamilyController::class, 'sendRequest']);
    Route::post('confirm-family-request', [FamilyController::class, 'confirmFamilyRequest']);
    Route::post('cancel-family-request', [FamilyController::class, 'cancelFamilyRequest']);
    Route::post('delete-family-request', [FamilyController::class, 'deleteFamily']);

    Route::post('change-online-status', [UserController::class, 'changeStatus']);

    Route::post('add-group', [GroupMembersController::class, 'store']);
    Route::get('add-group', [GroupController::class, 'index']);
    Route::post('confirm-group-request', [GroupMembersController::class, 'confirmRequest']);
    Route::post('cancel-group-request', [GroupMembersController::class, 'cancelRequest']);
    Route::post('leave-the-group', [GroupMembersController::class, 'leaveGroup']);
    Route::get('admin-delete-user/{id?}', [GroupController::class, 'AdminDeleteUsers']);
    Route::post('create-group', [GroupController::class, 'store']);
    Route::post('create-moderator', [GroupController::class, 'ModeratorCreate']);
    Route::post('AddMyAnswerInLoginGroup', [GroupController::class, 'AddMyAnswerInLoginGroup']);
    Route::get('your-group', [GroupController::class, 'YourGroup']);
    Route::post('LogoutInGroup', [GroupController::class,'LogoutInGroup']);
    Route::post('LoginInGroupRequest', [GroupController::class,'LoginInGroupRequest']);
    Route::post('GetGroupLoginRequest', [GroupController::class,'GetGroupLoginRequest']);
    Route::post('SuccessGroupLogin', [GroupController::class,'SuccessGroupLogin']);
    
    Route::post('AdminDeleteGroup', [GroupController::class,'AdminDeleteGroup']);


    Route::post('groupSettings', [GroupController::class, 'groupSettings']);
    Route::post('GetGroupFromFriendMember', [GroupController::class, 'GetGroupFromFriendMember']);
    Route::post('AddInviteGetGroupFromFriend', [GroupController::class, 'AddInviteGetGroupFromFriend']);
    Route::post('AddInviteGetGroupFromFriends', [GroupController::class, 'AddInviteGetGroupFromFriends']);
    Route::post('BlackListStatusInGroupAndDelete', [GroupController::class, 'BlackListStatusInGroupAndDelete']);
    Route::post('UserAddNewModeradorAnDelete',[GroupController::class, 'UserAddNewModeradorAnDelete']);

    Route::post('DeleteUserInGroup', [GroupController::class, 'DeleteUserInGroup']);



    Route::post('SearchUser', [UserController::class, 'SearchUser']);
    Route::get('DocumentsCategory', [UserController::class, 'DocumentsCategory']);
    Route::post('CreateNewDocument', [UserController::class,'CreateNewDocument' ]);
    Route::get('GetMyDocuments', [UserController::class,'GetMyDocuments' ]);
    Route::get('GetCountsFromProject', [UserController::class,'GetCountsFromProject' ]);



//      Stex  Kmiana  Vcharman hamakargic heto
//
//    Route::middleware([NoActiveUser::class])->group(function(){
//
//
//
//
//    });
//
//
//
//


    Route::post('buy_vatan_service_tranzaction', [BuyVatanServiceController::class, 'buy_vatan_service_tranzaction']);
    Route::post('buy_vatan_service_register', [BuyVatanServiceController::class, 'buy_vatan_service_register']);
    Route::post('add_balance', [BuyVatanServiceController::class, 'add_balance']);
    Route::post('suc_add_balance', [BuyVatanServiceController::class, 'suc_add_balance']);
    Route::post('err_add_balance', [BuyVatanServiceController::class, 'err_add_balance']);
    Route::get('get_history_buy', [BuyVatanServiceController::class, 'get_history_buy']);




});



Route::get('status/{id?}', [UserController::class, 'userOnlineStatus']);

////////////////////////////////////////////////////////////////////////////////  Crons URL
///

Route::get('CronDeleteImageTable', [\App\Http\Controllers\Cron\ImageDeletController::class, 'CronDeleteImageTable']);
Route::get('UpdateDateHolidayController', [\App\Http\Controllers\Cron\UpdateDateHolidayController::class, 'UpdateDateHolidayController']);



Route::post('change_token_valid', [UserController::class, 'change_token_valid']);







