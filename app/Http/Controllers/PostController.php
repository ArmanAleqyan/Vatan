<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\LoginInGroupRequest;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\Image;
use App\Events\PostNotification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image as RTY;
use Validator;

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;

use Cloudinary\Uploader;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use FFMpeg\FFProbe;


class PostController extends Controller
{

    /**
     * @OA\Post(
     * path="api/AllFile",
     * summary="AllFile",
     * description="AllFile",
     * operationId="AllFile",
     * tags={"Post"},
     * @OA\RequestBody(
     *    required=true,
     *    description="AllFile",
     *    @OA\JsonContent(
     *       required={"required"},
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
    public function AllFile(Request $request){
        $get = Post::where('user_id', \auth()->user()->id)->where('deleted_at', null)->get('id');
        if(!$get->isEmpty()){
            foreach ($get as $post){
                $data[] = $post->id;
            }
            $getImage = Image::wherein('post_id', $data)->where('deleted_at', null)->orderBy('created_at','Desc')->get();
        }else{
            $getImage = [];
        }
        return response()->json([
               'status' => true,
               'data' => $getImage
            ], 200);

    }

    public function postSinglePage($id){




      $data =  Post::where('id', $id)->with('images','user','comment', 'comment.user', 'PostLike', 'PostLikeAuthUser','comment.commmentlikeAuthUser',
            'comment.comentreply','comment.comentreply.user','comment.comentreply.commentsreplylikeAuthUser',
            'comment.comentreply.comentreplyanswer',
            'comment.comentreply.comentreplyanswer.user'
        )->where('deleted_at', null)->whererelation('user', 'id', '!=', null)
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
            ])->orderBy('id', 'desc')->get();

      if(isset($data)){
          $group = GroupUser::where('user_id', auth()->user()->id)->where('group_id', $data[0]->group_id)->first();

          if($group != null){
              $role = $group;
          }else{
              $role = [];
          }

      }



      if($data->isEmpty()){
          return response()->json([
             'status' => false,
              'message' => 'wrong post id'
          ],422);
      }
        return response()->json([
           'status' => true,
           'data' =>  $data,
            'role' => $role
        ],200);
    }

    /**
     * @OA\Post(
     * path="api/EditPost",
     * summary="EditPost",
     * description="EditPost",
     * operationId="EditPost",
     * tags={"Post"},
     * @OA\RequestBody(
     *    required=true,
     *    description="EditPost",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="description", type="string", format="text", example="some description"),
     *          @OA\Property(property="post_id", type="string", format="text", example="1"),
     *          @OA\Property(property="DeletePhoto[]", type="string", format="text", example="1 2"),
     *          @OA\Property(property="NewPhoto[]", type="string", format="file", example="asd"),
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

    public function EditPost(Request $request){
        $rules = array(
            'post_id' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $getPost = Post::where('id', $request->post_id)->get();

        if($getPost->isEmpty()){
            return response()->json([
               'status' => false,
               'message' => 'Wrong Post Id'
            ],422);
        }

        if($getPost[0]->user_id != \auth()->user()->id){
            return response()->json([
               'status' => false,
               'message' => 'No your Post'
            ],422);
        }


        

       $post =  Post::where('id', $request->post_id)->update([
           'description' => $request->description
        ]);



        if(isset($request->DeletePhoto)){
                $postImageDelete = Image::whereIN('id', $request->DeletePhoto)->update([
                    'deleted_at' => Carbon::now()
                ]);
//            }
//            $postImageDelete = Image::whereIn('id', $request->DeletePhoto)->get('image');
//            foreach ($postImageDelete as $del){
////                dump($del->image);
////                $image_path = "uploads/".$del->image;  // Value is not URL but directory file path
////                if(file_exists($image_path)){
////                    unlink($image_path);
////                }
//            }
//            $postImageDelete = Image::whereIn('id', $request->DeletePhoto)->update([
//                'deleted_at' => Carbon::now()
//            ]);
        }
        if(isset($request->NewPhoto)){
            $time = time();
            foreach ($request->NewPhoto as $photo){
                $TypeImg =$photo->getClientMimeType();
                if($TypeImg == 'image/jpeg' || $TypeImg == 'image/jpg' || $TypeImg == 'image/gif' || $TypeImg == 'image/png'  || $TypeImg == 'image/bmp'){
                    $image = $photo;
                    if($image->getSize() > 1000000){
                        $input['imagename'] = $time++.'.'.$image->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads');
                        $img = RTY::make($image->getRealPath());
                        $width =   getimagesize($photo)[0] / 3;
                        $height =   getimagesize($photo)[1] / 3;
                        $img->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath.'/'.$input['imagename']);

                        $files =      Image::create([
                            'post_id' => $request->post_id,
                            'image' => $img->basename
                        ]);

                    }else{
                        $destinationPath = 'uploads';
                        $originalFile = $time++ . $photo->getClientOriginalName();
                        $photo->move($destinationPath, $originalFile);
                        $files = $originalFile;
                        Image::create([
                            'post_id' => $request->post_id,
                            'image' => $files
                        ]);
                    }
                }        elseif ($TypeImg == 'video/mp4' || $TypeImg ==  'video/MP4'|| $TypeImg == 'video/AVI' || $TypeImg == 'video/MOV' ||$TypeImg == 'video/quicktime'){
                    $destinationPath = 'uploads/NewVideo';
                    $originalFile =  time(). $photo->getClientOriginalName();
                    $photo->storeas($destinationPath, $originalFile);
                    $filesname = $originalFile;

                    $files =      Image::create([
                        'post_id' =>  $request->post_id,
                        'image' => $filesname
                    ]);


//                    exec("ffmpeg -i /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/NewVideo/$filesname -vf 'scale=trunc(iw/4)*2:trunc(ih/4)*2' -c:v libx265 -crf 28  /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/$filesname");
//                    exec("ffmpeg -i /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/NewVideo/$filesname -b:v 360k -bufsize 360k /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/$filesname");
                    exec("ffmpeg -i /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/NewVideo/$filesname  /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/$filesname");
                    $image_path = "uploads/NewVideo/".$filesname;  // Value is not URL but directory file path
                    if(file_exists($image_path)){
                        unlink($image_path);
                    }
                }else{
                    $destinationPath = 'uploads';
                    $originalFile =  $time++. $photo->getClientOriginalName();
                    $photo->storeas($destinationPath, $originalFile);
                    $files = $originalFile;

                    $files =      Image::create([
                        'post_id' =>  $request->post_id,
                        'image' => $files
                    ]);
                }
            }
        }
       return response()->json([
          'status' => true,
          'message' =>  'postUpdated'
       ],200);
    }


    /**
     * @OA\Get(
     * path="api/DeletePost/post_id=2",
     * summary="DeletePost",
     * description="DeletePost",
     * operationId="DeletePost",
     * tags={"Post"},
     * @OA\RequestBody(
     *    required=true,
     *    description="EditPost",
     *    @OA\JsonContent(
     *       required={"required"},
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
    public function DeletePost($id){


        $getPost = Post::where('id', $id)->get();

        if($getPost->isEmpty()){
            return response()->json([
               'status' => false,
               'message' => 'Wrong Post Id'
            ], 422);
        }

        if($getPost[0]->user_id !=  \auth()->user()->id){
            return response()->json([
               'status' => false,
                'message' => 'Post No Your'
            ], 422);
        }


        $post = Post::where('id', $id)->update([
           'deleted_at' => Carbon::now()
        ]);
        return response()->json([
           'status' => true,
           'message' => 'Post Deleted'
        ], 200);
    }




    public function index()
    {
        $postData = Post::where('user_id', auth()->user()->id)->with(['comment', 'comment.comentreply'])->get();

        return response()->json([
            'success' => true,
            'message' => 'product was successfully created',
            'data' => $postData
        ], 201);
    }

    public function allpost(Request $request){
        $data = Friend::where('receiver_id', auth()->user()->id)
            ->where('status', 'true')
            ->orwhere('sender_id', auth()->user()->id)
            ->where('status', 'true')
            ->get(['sender_id', 'receiver_id']);

        if(!$data->isEmpty()){
            foreach ($data as $friend){
                $datas[] = $friend['sender_id'];
                $datas[] = $friend['receiver_id'];
            }
        }else{
            $datas[]= auth()->user()->id;
        }


        if(isset($request->group_id)){
            $getFGroup = Group::where('id', $request->group_id)->first();
            if($getFGroup == null || $getFGroup->deleted_at != null){
                return response()->json([
                   'status' => false,
                   'message' => 'Wrong Group Id'
                ],422);
            }
            $post = Post::where('group_id', $request->group_id)->where('deleted_at', null)->with('images','user','comment','PostLike', 'comment.commmentlikeAuthUser',
                'comment.comentreply','comment.comentreply.user','comment.comentreply.commentsreplylikeAuthUser',
                'comment.comentreply.comentreplyanswer',
                'comment.comentreply.comentreplyanswer.user',
                'comment.comentreply.comentreplyanswer.replyanswerlikeAuthUser'
            )->withCount('postlikes', 'comment')->whererelation('user', 'id', '!=', null)
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
                ->simplepaginate(15);

            $group = Group::where('id', $request->group_id)->get();

           $groupUserCount =   GroupUser::with('User')->where('group_id', $request->group_id)->where('status', '!=','BlackList')->get();
           $groupBlackList =   GroupUser::with('User')->where('group_id', $request->group_id)->where('status', '=','BlackList')->get();
           $groupUserRole =   GroupUser::where('group_id', $request->group_id)->where('user_id', auth()->user()->id)->first('status');
            $GroupLoginRequest = null;
           if($groupUserRole == null){
               if($group[0]->user_id == auth()->user()->id){
                   $groupUserRole = 'GeneralAdmin';
               }else{
                   $groupUserRole = 'NoMember';
                   $GroupLoginRequest = LoginInGroupRequest::with('LoginInGroupRequest')->where('sender_id', auth()->user()->id)->where('group_id', $request->group_id)->orderBy('id', 'desc')->get();
               }
           }else{
               $groupUserRole = $groupUserRole->status;
           }

            $dataInvite =  \App\Models\Groupmember::where('receiver_id', auth()->user()->id)
                ->where('user_status', 'unconfirm')->where('group_id', $request->group_id)
                ->with('sender','groupmembers')->orderBy('id', 'Desc')
                ->get();


            if(!$dataInvite ->isempty()){
                foreach ($dataInvite as $item){
                    $arrayInvite[] = [
                        'user_id' =>$item->sender->id,
                        'user_name' =>  $item->sender->name,
                        'user_surname' =>  $item->sender->surname,
                        'user_avatar' =>  $item->sender->avatar,
                        'request_id' => $item->id,
                        'group_name' =>$item->groupmembers->name,
                        'group_image' => $item->groupmembers->image,
                        'group_id' => $item->groupmembers->id,

                    ];
                }
            }else{
                $arrayInvite = [];
            }

            return response()->json([
                'status' => true,
                'post' => $post,
                'group' => $group,
                'count' => $groupUserCount->count(),
                'users' =>  $groupUserCount,
                'role' => $groupUserRole,
                'BlackList' => $groupBlackList,
                'GroupLoginRequest' =>$GroupLoginRequest,
                'Invite' =>$arrayInvite
            ],200);
        }else{
            $post = Post::whereIn('user_id', $datas)->with('images','user','comment', 'comment.user', 'PostLike', 'PostLikeAuthUser','comment.commmentlikeAuthUser',
                'comment.comentreply','comment.comentreply.user','comment.comentreply.commentsreplylikeAuthUser',
                'comment.comentreply.comentreplyanswer',
                'comment.comentreply.comentreplyanswer.user',
                'comment.comentreply.comentreplyanswer.replyanswerlikeAuthUser'
            )->where('deleted_at', null)->whererelation('user', 'id', '!=', null)
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
        }


        return response()->json([
           'status' => true,
           'date' => $post
        ],200);
    }



    public function friendsPosts()
    {
        $data = Friend::where('receiver_id', auth()->user()->id)->where('status', 'true')->with('sender')->get();
        $usersPostData = [];
        foreach ($data as $datum) {
            $friendId = $datum['sender']['id'];
            $usersPost = User::where('id', $friendId)->with(['post.comment.comentreply'])->get();
            $usersPostData[] = $usersPost;
        }
        if (!$data->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => "these are your friend's posts",
                'data' => $usersPostData,
            ]);
        } else {
            return response()->json([
                'success' => false,
                "message" => "you dont have friends"
            ]);
        }
    }

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



        if($request->description == null && $request->file == null){
            return response()->json([
               'status' => false,
               'message' =>  'Empty FormData'
            ],422);
        }


        if(isset($request->file)){
            $time = time();
            $post = Post::create([
                'description' => $request->description,
                'user_id' => \auth()->user()->id,
                'group_id' => $request->group_id
            ]);
            $file = $request->file('file');

            foreach ($file as $files){
                    $TypeImg =$files->getClientMimeType();
                if($TypeImg == 'image/jpeg' || $TypeImg == 'image/jpg' || $TypeImg == 'image/gif' || $TypeImg == 'image/png'  || $TypeImg == 'image/bmp'){
                    $image = $files;
             if($image->getSize() > 1000000){
                 $input['imagename'] = $time++.'.'.$image->guessExtension();
                 $destinationPath = public_path('/uploads');
                 $img = RTY::make($image->getRealPath());
                 $width =   getimagesize($files)[0] / 3;
                 $height =   getimagesize($files)[1] / 3;
                 $img->resize($width, $height, function ($constraint) {
                     $constraint->aspectRatio();
                 })->save($destinationPath.'/'.$input['imagename']);

                 $files =      Image::create([
                     'post_id' => $post->id,
                     'image' => $img->basename
                 ]);
             }
             else{
                 $destinationPath = 'uploads';
                 $originalFile =  $time++.'.' .$files->guessExtension();
                 $files->storeas($destinationPath, $originalFile);
                 $files = $originalFile;


                 $files =      Image::create([
                     'post_id' => $post->id,
                     'image' => $files
                 ]);
             }

         }
                elseif ($TypeImg == 'video/mp4' || $TypeImg ==  'video/MP4'||  $TypeImg == 'video/AVI' || $TypeImg == 'video/MOV' ||$TypeImg == 'video/quicktime'){


                    $destinationPath = 'uploads/NewVideo';
                    $originalFile =  time().'.'.$files->guessExtension() ;
                    $files->storeas($destinationPath, $originalFile);
                    $filesname = $originalFile;


                    $files =      Image::create([
                        'post_id' => $post->id,
                        'image' => $filesname
                    ]);


//                    exec("ffmpeg -i /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/NewVideo/$filesname -vf 'scale=trunc(iw/4)*2:trunc(ih/4)*2' -c:v libx265 -crf 28  /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/$filesname");
//                    exec("ffmpeg -i /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/NewVideo/$filesname -b:v 360k -bufsize 360k /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/$filesname");
                    exec("ffmpeg -i /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/NewVideo/$filesname  /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/$filesname");
                    $image_path = "uploads/NewVideo/".$filesname;  // Value is not URL but directory file path
                    if(file_exists($image_path)){
                        unlink($image_path);
                    }
                } else{
             $destinationPath = 'uploads';
             $originalFile =  $time++.'.'.$files->guessExtension();
             $files->storeas($destinationPath, $originalFile);
             $files = $originalFile;

             $files =      Image::create([
                 'post_id' => $post->id,
                 'image' => $files
             ]);
         }


//                ffmpeg -i 1674810250lake_aerial_view_drone_flight_view_943.mp4 -b:v 144k -bufsize 144k output.mp4




            }

            return response()->json([
               'status'  => true,
                'message' => 'post created with file'
            ]);
        }else{
            $post = Post::create([
                'description' => $request->description,
                'user_id' => \auth()->user()->id,
                'group_id' => $request->group_id
            ]);
            return response()->json([
                'status'  => true,
                'message' => 'post created'
            ]);
        }


//
//        event(new PostNotification($data, $user));
//        return response()->json([
//            'success' => true,
//            'message' => 'product was successfully created'
//        ], 201);
    }
}
