<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Friend;

class FriendsController extends Controller
{
    public function index()
    {
        $data = Friend::where('receiver_id', auth()->user()->id)->where('status', true)->with('sender')->get();
        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'your request sended'
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
        ];

        $addFriends = Friend::create($friendData);

        if ($addFriends) {
            return response()->json([
                'success' => true,
                'message' => 'your request sended'
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
                ->where('sender_id', $request->sender_id)->update(['status' => true]);

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
        $cacnelRequest = Friend::where('receiver_id', auth()->user()->id)
            ->where('sender_id', $request->sender_id)->update(['status' => false]);

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
            ->where('sender_id', $request->sender_id)->delete();

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
}
