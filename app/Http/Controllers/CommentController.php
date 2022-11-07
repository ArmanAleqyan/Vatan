<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CommentController extends Controller
{

    /**
     * @OA\Post(
     * path="api/comment",
     * summary="User Create Comments",
     * description="User Create Comments",
     * operationId="Users Create Comments",
     * tags={"Comments"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Create Comments",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="comment", type="string",format="text", example="some comment"),
     *               @OA\Property(property="post_id", type="integer",format="text", example="1"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="User Create Comments",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $comment = [
            'comment' => $request->comment,
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
        ];
        DB::beginTransaction();

        $CreatComment = Comment::create($comment);

        $notificationPost = Post::where('id', $request->post_id)
            ->first();

        $notificationCreate = Notification::create([
            'notification_type' => 'new comment',
            'sender_id' => auth()->user()->id,
            'receiver_id' => $notificationPost['user_id']
        ]);
        $notificationData = $notificationCreate->with(['sendernotification', 'receivernotification'])->get();

        DB::commit();

        if ($CreatComment) {
            return response()->json([
                'success' => true,
                'message' => 'comment added successfully',
                'data' => $notificationData
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'something was wrong'
            ], 422);
        }
    }
}
