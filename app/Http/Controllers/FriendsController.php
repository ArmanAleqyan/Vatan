<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use App\Models\Friend;
use App\Models\Holiday;
use App\Models\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Events\FriendRequestEvent;

class FriendsController extends Controller
{



    public function index()
    {
        $data = Friend::where('receiver_id', auth()->user()->id)
            ->where('status', 'unconfirm')
            ->with('sender')
            ->get();

//        $userData = [];
//
//        foreach ($data as $datum) {
//            $int = (int)$datum['sender_id'];
//
//            $userss = User::where('id', $int)->get();
////            $userData[] = $userss;
//        }

//        event(new FriendRequestEvent($userss));
        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'sent you a request',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ]);
        }
    }

    public function AllFriends()
    {
        $data = Friend::where('receiver_id', auth()->user()->id)->where('status', 'true')
            ->OrWhere('sender_id',auth()->user()->id)->where('status', 'true')->get(['sender_id','receiver_id']);



        foreach ($data as $user ){
                if($user->sender_id == auth()->user()->id){
                    $userArray[] = $user->receiver_id;
                }else{
                    $userArray[] = $user->sender_id;
                }
            }
        if($data->isEMpty()){
            $userArray = [];
        }



        $getUser = User::whereIn('id', $userArray)->OrderBy('name','asc')->get();

        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'your friends',
                'data' => $getUser,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ]);
        }
    }


    /**
     * @OA\Post(
     * path="api/add-friends",
     * summary="User Send Request",
     * description="User Send Request",
     * operationId="Users Send Request",
     * tags={"Friends"},
     * @OA\RequestBody(
     *    required=true,
     *    description="user sent a friend pressure request",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="receiver_id", type="integer",format="text", example="1"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="user sent a friend pressure request",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->with('sender')->get();
        $friendData = [
            'receiver_id' => $request->receiver_id,
            'sender_id' => auth()->user()->id,
            'status' => 'unconfirm'
        ];

//        DB::beginTransaction();

        $requesCount = Friend::where('receiver_id', $request->receiver_id)
            ->where('sender_id', auth()->user()->id)->get();
        if ($requesCount->count() < 1) {
            $addFriends = Friend::create($friendData);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'you have a already sent request'
            ], 422);
        }

        $notificationFriends = Friend::where('receiver_id', $request->receiver_id)->with('receiver')
            ->get();

//        DB::commit();

        if ($addFriends) {
            return response()->json([
                'success' => true,
                'message' => 'your request sended',
                'data' => $notificationFriends,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong',
            ]);
        }
    }


    /**
     * @OA\Post(
     * path="api/confirm-request",
     * summary="user accepts friend request",
     * description="user accepts friend request",
     * operationId="user accepts friend request",
     * tags={"Friends"},
     * @OA\RequestBody(
     *    required=true,
     *    description="user accepts friend request",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="sender_id", type="integer",format="text", example="1"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="user accepts friend request",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function confirmRequest(Request $request)
    {
        $confirm = Friend::where('receiver_id', auth()->user()->id)
            ->where('sender_id', $request->sender_id)->with('sender')->get();

        if ($confirm->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'sender not found'
            ], 404);
        } else {
            $confirmSuccess = Friend::where('receiver_id', auth()->user()->id)
                ->where('sender_id', $request->sender_id)->update(['status' => 'true']);

            if ($confirmSuccess) {
                return response()->json([
                    'success' => true,
                    'message' => 'you have successfully accepted the request'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong'
                ], 422);
            }
        }
    }


    /**
     * @OA\Post(
     * path="api/cancel-request",
     * summary="user request canceled",
     * description="user request canceled",
     * operationId="user request canceled",
     * tags={"Friends"},
     * @OA\RequestBody(
     *    required=true,
     *    description="user request canceled",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="sender_id", type="integer",format="text", example="1"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="user request canceled",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function cancelRequest(Request $request)
    {
//        $cacnelRequest = Friend::where('receiver_id', auth()->user()->id)
//            ->where('sender_id', $request->sender_id)->update(['status' => 'false']);

        $cacnelRequest = Friend::where('receiver_id', auth()->user()->id)
            ->where('sender_id', $request->sender_id)->delete();

        if ($cacnelRequest) {
            return response()->json([
                'success' => true,
                'message' => 'request canceled'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ], 422);
        }
    }

    /**
     * @OA\Post(
     * path="api/delete-friend",
     * summary="user removed from friends list",
     * description="user removed from friends list",
     * operationId="user removed from friends list",
     * tags={"Friends"},
     * @OA\RequestBody(
     *    required=true,
     *    description="user removed from friends list",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="sender_id", type="integer",format="text", example="1"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="user removed from friends list",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function deleteFriend(Request $request)
    {
        $cacnelRequest = Friend::where('receiver_id', auth()->user()->id)
            ->where('sender_id', $request->sender_id)->orwhere('receiver_id', $request->sender_id)->where('sender_id', auth()->user()->id)->delete();

        if ($cacnelRequest) {
            return response()->json([
                'success' => true,
                'message' => 'user successfully removed from your friends list'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ], 422);
        }
    }

    /**
     * @OA\Post(
     * path="api/deleteMyFriendRequest",
     * summary="deleteMyFriendRequest",
     * description="deleteMyFriendRequest",
     * operationId="deleteMyFriendRequest",
     * tags={"Friends"},
     * @OA\RequestBody(
     *    required=true,
     *    description="user removed from friends list",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="receiver_id", type="integer",format="text", example="1"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="user removed from friends list",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function deleteMyFriendRequest(Request $request){
        Friend::where('sender_id', auth()->user()->id)->where('receiver_id', $request->receiver_id)->delete();
        return response()->json([
           'status' => true,
           'message' => 'Friend Request Deleted'
        ],200);
    }

    /**
     * @OA\Post(
     * path="api/friends-birth",
     * summary="get users birthday",
     * description="get users birthday",
     * operationId="get user birthday",
     * tags={"Friends"},
     * @OA\RequestBody(
     *    required=true,
     *    description="get users birthday",
     *    @OA\JsonContent(
     *               required={"true"},
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="get users birthday",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */



    public function friendsBirth(Request $request){

        $data = Friend::where('receiver_id', auth()->user()->id)
            ->where('status', 'true')
            ->orwhere('sender_id', auth()->user()->id)
            ->where('status', 'true')
            ->get(['sender_id', 'receiver_id']);

        if(!$data->isEmpty()){
            foreach ($data as $friend){
                if($friend['sender_id'] == \auth()->user()->id){
                    $datas[] = $friend['receiver_id'];
                }else{
                    $datas[] = $friend['sender_id'];
                }
            }
        }else{
            $datas = [];
        }


        $today = Carbon::now();
        $today2 = Carbon::now();
        $getUser = User::whereIn('id', $datas)
            ->whereMonth('date_of_birth', '=', $today->month)
            ->orwhereMonth('date_of_birth', '=', $today->month +1)
            ->whereDay('date_of_birth', '>=', $today->day)
            ->whereDay('date_of_birth', '<=',  $today2 ->addDays(6)->day)
            ->orderBY('day')->get();

        foreach ($getUser as $user){
//            dd($user->date_of_birth->year);
            $user->date_of_birth->year = Carbon::now()->year;
            $a = Carbon::parse($user->date_of_birth);
            $a->year = Carbon::now()->year;
            $user['NewDateString'] =$a->diffForHumans();
        }



        $Date = Carbon::now()->format('Y');


        $holiday = Holiday::
            whereBetween(
            'dateTime', array($today->addDays(-1), $today2))
            ->orderBY('dateTime','ASC')->get();




//        dd($holiday);

//            dd($holiday);
//            foreach ($holiday as $hol){
//                if ($hol->month < 10){
//                    $mount = '0'.$hol->month;
//                }else{
//                    $mount = $hol->month;
//                }
//
//                if ($hol->day < 10){
//                    $day = '0'.$hol->day;
//                }else{
//                    $day = $hol->day;
//                }
//              $date = Carbon::now()->year.$mount.$day;
//                $birthdate = Carbon::parse($date);
//                if($birthdate = Carbon::now() || $birthdate > Carbon::now() && $birthdate <= $today2->addDays(5)->day){
//
//                    $birthHol[] = [
//                        'id' =>  $hol->id,
//                        'title' => $hol->title
//                    ];
//                }
//            }
//
//            dd($birthHol);


        foreach ($holiday as $item) {
            if($item->month < 10){
                $month = '0'.$item->month;
            }else{
                $month = $item->month;
            }
            $test = Carbon::parse($Date.$month.$item->day);
            $item['date'] = $test;


            if($item->dateTime->format('Y m d') == Carbon::now()->format('Y m d')){

                $item['NewDateString'] ='Сегодня';
            }else{
                $item['NewDateString'] = $item->dateTime->diffForHumans();

            }
        }


        return response()->json([
           'status' => true,
           'users' => $getUser,
            'holiday' => $holiday
        ],200);
    }

    /**
     * @OA\Post(
     * path="api/SinglePageholiday/id",
     * summary="SinglePageholiday",
     * description="SinglePageholiday",
     * operationId="SinglePageholiday",
     * tags={"SinglePageholiday"},
     * @OA\RequestBody(
     *    required=true,
     *    description="SinglePageholiday",
     *    @OA\JsonContent(
     *               required={"true"},
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="get users birthday",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function SinglePageholiday($id){
        $holiday = Holiday::where('id', $id)->get();

        return response()->json([
           'status' => true,
           'data' =>  $holiday
        ],200);
    }
}
