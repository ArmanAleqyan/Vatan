<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentreply;
use App\Models\Comment;
use App\Models\Post;


class CommentReplyController extends Controller
{
    /**
     * @OA\Post(
     * path="api/comment-reply",
     * summary="User Create Comments Reply",
     * description="User Create Comments Reply",
     * operationId="User Create Comments Reply",
     * tags={"Comments"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Create Comments",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="comment_reply", type="string",format="text", example="some comment"),
     *               @OA\Property(property="comment_id", type="integer",format="text", example="1"),
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
            'comment_id' => $request->comment_id,
            'user_id' => auth()->user()->id,
            'comment_reply' => $request->comment_reply
        ]; 
        $create = Comentreply::create($CommentReply);
        if ($create) {
            return response()->json([
                'success' => true,
                'message' => 'comment reply successfully created',
                'data' => $CommentReply,
                'user'=>auth()->user(),
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'something was wrong',
            ], 422);
        }
    }
}
