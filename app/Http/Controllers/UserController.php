<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Group;
use App\Models\VatanServiceDocumentList;
use App\Models\UserDocument;
use Validator;
use App\Models\Friend;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Image as RTY;


class UserController extends Controller
{

    /**
     * @OA\Post(
     * path="api/CreateNewDocument",
     * summary="CreateNewDocument",
     * description="CreateNewDocument",
     * operationId="CreateNewDocument",
     * tags={"Profile"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Send Email for add",
     *    @OA\JsonContent(
     *       required={"required"},
     *         @OA\Property(property="document_id", type="document_id", format="document_id", example="1,3"),
     *         @OA\Property(property="photo", type="photo[]", format="photo", example="file"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Empty Post Request With Token",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */
    public function CreateNewDocument(Request $request){
        $rules=array(
            'document_id' => 'required',
            'photo' => 'required',
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }
        $getDocType = VatanServiceDocumentList::where('id' , $request->document_id)->first();
        if($getDocType == null){
            return response()->json([
               'status' => false,
               'message' => 'Wrong Document_id'
            ],422);
        }else{
            $file = $request->file('photo');
            foreach ($file as $files){
                $fileName = uniqid() . '.' . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $fileName);

                UserDocument::create([
                    'user_id' => \auth()->user()->id,
                    'document_id' => $request->document_id,
                    'document_name' => $getDocType->name,
                    'photo' => $fileName
                ]);
            }
            return response()->json([
               'status' => true,
               'message' =>  'Document created  Pleace White Admin Moderating'
            ]);
        }






    }

    /**
     * @OA\Get(
     * path="api/GetMyDocuments",
     * summary="GetMyDocuments",
     * description="GetMyDocuments",
     * operationId="GetMyDocuments",
     * tags={"Profile"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Send Email for add",
     *    @OA\JsonContent(
     *       required={"required"},
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Empty Post Request With Token",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function GetMyDocuments(Request $request){
            $get = UserDocument::where('user_id', \auth()->user()->id)->with('user_documents')->get();
            return response()->json([
               'status' => true,
               'message' => $get
            ],200);
    }



    public function SearchUser(Request $request){
        $rules = array(
            'search' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $keyword = $request->search;
        $name_parts = explode(" ", $keyword);

        $users = User::query();

        foreach ($name_parts as $part) {
            $users->orWhere(function ($query) use ($part) {
                $query->where('id', '!=', auth()->user()->id)
                    ->where('name', 'like', "%{$part}%")
                    ->orWhere('surname', 'like', "%{$part}%")
                    ->where('id', '!=', auth()->user()->id)
                    ->orwhere('username', 'like', "%{$part}%")
                    ->where('id', '!=', auth()->user()->id)
                    ->orwhere('patronymic', 'like', "%{$part}%");
            });
        }

        $users = $users->get();

//     $user =    User::where('name', 'Like', '%'.$request->search)
//         ->orwhere('surname', 'Like', '%'.$request->search)
//         ->orwhere('patronymic', 'Like', '%'.$request->search)
//            ->orwhere('username', 'Like', '%'.$request->search)->get();

//         $user =    User::where('name', $request->search)->where('id', '!=', auth()->user()->id)
//            ->orwhere('surname', $request->search)
//            ->orwhere('patronymic', $request->search)
//            ->orwhere('username', $request->search)->get();

        $group = Group::where('name',  'like', "%{$request->search}%")->get();

     return response()->json([
        'status' => true,
        'user' =>  $users,
         'group' => $group,
//         'NewUsers'  => $users
     ],200);
    }




    public function index()
    {
        $user = auth()->user();

        if ($user) {
            return response()->json([
                'success' => true,
                $user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
            ], 422);
        }
    }

    /**
     * @OA\Post(
     * path="api/change-online-status",
     * summary="change-online-status",
     * description="change-online-status",
     * operationId="change-online-status",
     * tags={"Profile"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Send Email for add",
     *    @OA\JsonContent(
     *       required={"required"},
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Empty Post Request With Token",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function changeStatus(Request $request)
    {
        $checkStatus = User::where('id', auth()->user()->id)->get();
        if ($checkStatus[0]->last_seen == 'online') {
            $checkStatus = User::where('id', auth()->user()->id)->update(['last_seen' => 'offline']);
            if ($checkStatus) {
                return response()->json([
                    'success' => true,
                    'message' => 'status changed online successfully'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong'
                ], 422);
            }
        } else {
            $checkStatus = User::where('id', auth()->user()->id)->update(['last_seen' => 'online']);
            if ($checkStatus) {
                return response()->json([
                    'success' => true,
                    'message' => 'status changed offline successfully'
                ], 200);
            }
        }
    }

    public function userOnlineStatus($id)
    {
        $data = User::where('id', $id)->get();

        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'user with this id not found'
            ], 200);
        } else {
            $minute = \Carbon\Carbon::parse($data[0]->last_seen)->diffForHumans();
            return response()->json([
                'success' => true,
                'last seen' => $minute
            ]);
        }
    }

    public function logout()
    {
        $user = Auth::user()->token();
//        if ($user) {
//            $offline = User::where('id', auth()->user()->id)->update(['last_seen' => Carbon::now()]);
//            $offlineUser = User::where('id', auth()->user()->id)->get();
//            $stringToTime = strtotime($offlineUser[0]->last_seen);
//            $minute = \Carbon\Carbon::parse($stringToTime)->diffForHumans();
//        }

        $user->revoke();
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'this user is offline',
//                'user' => $minute
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'something was wrong'
            ], 422);
        }
    }

    public function profile()
    {

        $auth = User::where('id', auth()->user()->id)->with('post.comment')->get();

         $post = Post::where('user_id', auth()->user()->id)->where('group_id', null)->where('deleted_at', '=', null)->with('images','user','comment', 'comment.user', 'PostLike', 'PostLikeAuthUser','comment.commmentlikeAuthUser',
            'comment.comentreply','comment.comentreply.user','comment.comentreply.commentsreplylikeAuthUser',
            'comment.comentreply.comentreplyanswer',
            'comment.comentreply.comentreplyanswer.user'
        )->whererelation('user', 'id', '!=', null)
            ->withCount('postlikes', 'comment')
            ->with([
                'comment' => function ($query) {
                    $query->withCount('commmentlike')->withCount('comentreply');
                },
                'comment.comentreply' => function ($query) {
                    $query->withCount('commentsreplylike')->withCount('comentreplyanswer');
                }
                ,
                'comment.comentreply.comentreplyanswer' => function ($query) {
                    $query->withCount('replyanswerlike');
                },
            ])->where('group_id', null)->orderBy('id', 'desc')
            ->simplepaginate(15);



        if ($auth) {
            return response()->json([
                'status' => true,
                'message' => 'user profile',
                'data' => $auth,
                'post' => $post
            ], 200);
        } else
            return response()->json([
                'status' => false,
                'message' => 'something was wrong'
            ], 422);
        }

    public function OtherProfile($id)
    {
        $auth = User::where('id', $id)->with('post.comment')->get();
        if ($auth) { 
            return response()->json([
                'status' => true,
                'message' => 'user profile',
                'data' => $auth
            ], 200);
        } else
            return response()->json([
                'status' => false,
                'message' => 'something was wrong'
            ], 422);
    }



    public function singlePageUser($id){
        
        $user = User::where('id', $id)->get();
        $post = Post::where('user_id',$id)->where('deleted_at',null)->where('group_id', null)->with('images','user','comment', 'comment.commmentlikeAuthUser',
            'comment.comentreply','comment.comentreply.user','comment.comentreply.commentsreplylikeAuthUser',
            'comment.comentreply.comentreplyanswer',
            'comment.comentreply.comentreplyanswer.user'
        )
            ->withCount('postlikes', 'comment')
            ->with([
                'comment' => function ($query) {
                    $query->withCount('commmentlike')->withCount('comentreply');
                },
                'comment.comentreply' => function ($query) {
                    $query->withCount('commentsreplylike')->withCount('comentreplyanswer');
                }
                ,
                'comment.comentreply.comentreplyanswer' => function ($query) {
                    $query->withCount('replyanswerlike');
                },
            ])
            ->orderBy('id', 'desc')
            ->get();

        $friend = Friend::where('sender_id',auth()->user()->id)->where('receiver_id', $id)
            ->orWhere('receiver_id', auth()->user()->id)->where('sender_id', $id)->get();


        return response()->json([
           'status' => true,
            'data' => $user,
            'post' => $post,
            'friend' => $friend
        ],200);
    }


    public function UpdatePhotoAndBagraundPhoto(Request $request){


        if(isset($request->avatar)){
            try{
                $TypeImg =$request->avatar->getClientMimeType();
                $photo = $request->avatar;
                if($TypeImg == 'image/jpeg' || $TypeImg == 'image/jpg' || $TypeImg == 'image/gif' || $TypeImg == 'image/png'  || $TypeImg == 'image/bmp') {
                    if ($photo->getSize() > 1000000) {
                        $input['imagename'] = time() . '.' . $photo->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads');
                        $img = RTY::make($photo->getRealPath());
                        $width = getimagesize($photo)[0] / 3;
                        $height = getimagesize($photo)[1] / 3;
                        $img->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath . '/' . $input['imagename']);
                        User::where('id', auth()->user()->id)->update([
                            'avatar' => $img->basename,
                        ]);
                        return response()->json([
                            'status' => true,
                            'message' => 'photo updated',
                            'photo' => $img->basename
                        ]);
                    } else {
                        $destinationPath = 'uploads';
                        $originalFile = time() . $photo->getClientOriginalName();
                        $photo->move($destinationPath, $originalFile);
                        $files = $originalFile;

                        User::where('id', auth()->user()->id)->update([
                            'avatar' =>$files,
                        ]);
                        return response()->json([
                            'status' => true,
                            'message' => 'photo updated',
                            'photo' => $files
                        ]);
                    }
                }else{
                    $destinationPath = 'uploads';
                    $originalFile = time() . $photo->getClientOriginalName();
                    $photo->move($destinationPath, $originalFile);
                    $files = $originalFile;

                    User::where('id', auth()->user()->id)->update([
                        'avatar' => $files,
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'photo updated',
                        'photo' => $files
                    ]);
                }
            }catch (\Exception $e){
                return response()->json([
                   'status' => false,
                   'message' =>  'Big data max 30MB'
                ]);
            }
//            User::where('id', auth()->user()->id)->update([
//                'avatar' => $img->basename,
//            ]);
//            return response()->json([
//                'status' => true,
//                'message' => 'photo updated',
//                'photo' => $avatar
//            ]);
        }
       elseif(isset($request->backraundPhoto)){
            try{
                $TypeImg =$request->backraundPhoto->getClientMimeType();
                $photo = $request->backraundPhoto;
                if($TypeImg == 'image/jpeg' || $TypeImg == 'image/jpg' || $TypeImg == 'image/gif' || $TypeImg == 'image/png'  || $TypeImg == 'image/bmp') {
                    if ($photo->getSize() > 1000000) {
                        $input['imagename'] = time() . '.' . $photo->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads');
                        $img = RTY::make($photo->getRealPath());
                        $width = getimagesize($photo)[0] / 3;
                        $height = getimagesize($photo)[1] / 3;
                        $img->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath . '/' . $input['imagename']);
                        User::where('id', auth()->user()->id)->update([
                            'backraundPhoto' => $img->basename,
                        ]);
                        return response()->json([
                            'status' => true,
                            'message' => 'photo updated',
                            'photo' => $img ->basename
                        ]);
                    } else {
                        $destinationPath = 'uploads';
                        $originalFile = time() . $photo->getClientOriginalName();
                        $photo->move($destinationPath, $originalFile);
                        $files = $originalFile;

                        User::where('id', auth()->user()->id)->update([
                            'backraundPhoto' =>$files,
                        ]);
                        return response()->json([
                            'status' => true,
                            'message' => 'photo updated',
                            'photo' => $files
                        ]);
                    }
                }else{
                    $destinationPath = 'uploads';
                    $originalFile = time() . $photo->getClientOriginalName();
                    $photo->move($destinationPath, $originalFile);
                    $files = $originalFile;

                    User::where('id', auth()->user()->id)->update([
                        'backraundPhoto' => $files,
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'photo updated',
                        'photo' => $files
                    ]);
                }


//                $avatar = $request->file('backraundPhoto');
//                $destinationPath = 'uploads';
//                $originalFile = time() . $avatar->getClientOriginalName();
//                $avatar->move($destinationPath, $originalFile);
//                $avatar = $originalFile;
            }catch (\Exception $e){
                return response()->json([
                    'status' => false,
                    'message' =>  'Big data max 30MB'
                ]);
            }

//            User::where('id', auth()->user()->id)->update([
//                'backraundPhoto' => $avatar,
//            ]);
//            return response()->json([
//                'status' => true,
//                'message' => 'backraund updated',
//                'photo' => $avatar
//            ]);
        }else{
            return  response([
                'status' => false,
                'message' =>  'wrong details'
            ], 422);
        }
    }

}


