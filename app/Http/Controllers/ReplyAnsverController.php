<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentreply;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Replyanswer;
use App\Models\User;


class ReplyAnsverController extends Controller
{
    /**
     * @OA\Post(
     * path="api/comment-reply-answer",
     * summary="User Create Comments Replys",
     * description="User Create Comments Replys",
     * operationId="User Create Comments Replys",
     * tags={"Comments"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Create Comments Reply",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="reply", type="string",format="text", example="some comment"),
     *               @OA\Property(property="reply_id", type="integer",format="text", example="1"),
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

        $CommentReply = [
            'user_id' => auth()->user()->id,
            'reply' => $request->reply,
            'reply_id' => $request->reply_id
        ];
        $create = Replyanswer::create($CommentReply);
        if ($create) {
            return response()->json([
                'success' => true,
                'message' => 'answer to answer reply successfully created',
                'data' => $CommentReply,
                'user' => auth()->user(),
            ], 200);
        } else {
            return response()->json([
                'success' => true,

                'message' => 'something was wrong',
            ], 422);
        }
    }
}
