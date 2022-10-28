<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\Image;
use App\Mail\Post;
use Validator;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $rules = array(
            'number' => 'min:3|max:64|unique:users',
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
        $product = Post::query()->create($data);
        if (count($fileNames)) {
            foreach ($fileNames as $fileName) {
                $image = $request->file($fileName);
                $destinationPath = 'public/uploads';
                $originalFile = time() . $image->getClientOriginalName();

                $image->storeAs($destinationPath, $originalFile);
                Image::create([
                    'product_id' => $product->id,
                    'image' => $originalFile
                ]);
            }
        }
        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'product was successfully created'
        ], 201);
    }
}
