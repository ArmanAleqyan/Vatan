<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;
use Validator;

class PostController extends Controller
{

    /**
     * @OA\Post(
     * path="api/post",
     * summary="User Create Posts",
     * description="User Create Posts",
     * operationId="Users Create Posts",
     * tags={"Post"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Users Create Posts",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="description", type="string", format="text", example="some description"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Wrong credentials response",
     *
     *
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $rules = array(
            'description' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $fileNames = array_keys($request->allFiles());
        $data = $request->except($fileNames);
        $fileNames = array_keys($request->allFiles());
        $data['user_id'] = Auth::user()->id;
        DB::beginTransaction();
        $post = Post::query()->create($data);
        if (count($fileNames)) {
            foreach ($fileNames as $fileName) {
                $images = $request->file($fileName);
                $test = [];
                $time = time();
                foreach ($images as $image) {

                    $destinationPath = 'uploads';
                    $originalFile = $time++ . $image->getClientOriginalName();
                    $image->move($destinationPath, $originalFile);

                    $test[] = $image->getPathname();
                    Image::create([
                        'post_id' => $post->id,
                        'image' => $originalFile
                    ]);
                }
            }
        }
        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'product was successfully created'
        ], 201);
    }
}
