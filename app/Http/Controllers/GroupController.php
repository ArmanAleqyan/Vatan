<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\LoginInGroupRequest;
use App\Models\Post;
use App\Models\Friend;
use App\Models\Groupmember;
use Illuminate\Support\Facades\Gate;
use App\Events\GroupRequestEvent;
use Validator;

use App\Models\GroupUser;


class GroupController extends Controller
{

    /**
     * @OA\Post(
     * path="api/AdminDeleteGroup",
     * summary="AdminDeleteGroup",
     * description="AdminDeleteGroup",
     * operationId="AdminDeleteGroup",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="AdminDeleteGroup",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="group_id", type="string",format="text", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="DeleteUserInGroup",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function AdminDeleteGroup(Request $request){
        Group::where('id', $request->group_id)->update([
           'deleted_at' => Carbon::now()
        ]);

        Post::where('group_id', $request->group_id)->update([
           'deleted_at' => Carbon::now()
        ]);


        GroupUser::where('group_id',  $request->group_id)->delete();


        return response()->json([
           'status' => 'true',
            'message' => 'Group Deleted'
        ],200);
    }

    /**
     * @OA\Post(
     * path="api/DeleteUserInGroup",
     * summary="DeleteUserInGroup",
     * description="DeleteUserInGroup",
     * operationId="DeleteUserInGroup",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="DeleteUserInGroup",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="user_id", type="string",format="user_id", example="1"),
     *               @OA\Property(property="group_id", type="string",format="text", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="DeleteUserInGroup",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function DeleteUserInGroup(Request $request){

        GroupUser::where('user_id', $request->user_id)->where('group_id', $request->group_id)->delete();

        return response()->json([
           'status' => true,
           'message' => 'user Deleted'
        ],200);
    }


    /**
     * @OA\Post(
     * path="api/SuccessGroupLogin",
     * summary="SuccessGroupLogin",
     * description="SuccessGroupLogin",
     * operationId="SuccessGroupLogin",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="SuccessGroupLogin",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="request_id", type="string",format="text", example="1"),
     *               @OA\Property(property="TrueOrFalse", type="string",format="text", example="True Or False"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="SuccessGroupLogin",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function SuccessGroupLogin(Request $request){
        $rules = array(
            'TrueOrFalse' => 'required',
            'request_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $get =  LoginInGroupRequest::where('id', $request->request_id)->first();

            if($get == null){
                    return response()->json([
                       'status' => false,
                       'message' =>  'Wrong request_id'
                    ],422);
            }else{
                if($request->TrueOrFalse == false){
                    LoginInGroupRequest::where('id', $request->request_id) ->delete();
                    return response()->json([
                       'status' => true,
                       'message' => 'Request Deleted'
                    ],200);
                }elseif ($request->TrueOrFalse == true){
                    LoginInGroupRequest::where('id', $request->request_id) ->delete();
                    GroupUser::create([
                       'user_id' => $get->sender_id,
                       'group_id' => $get->group_id,
                       'status' => 'user'
                    ]);


                    return response()->json([
                       'status' => true,
                       'message' => 'User Added in Group'
                    ],200);
                }
            }

    }

    /**
     * @OA\Post(
     * path="api/GetGroupLoginRequest",
     * summary="GetGroupLoginRequest",
     * description="GetGroupLoginRequest",
     * operationId="GetGroupLoginRequest",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="GetGroupLoginRequest",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="group_id", type="string",format="text", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="LoginInGroupRequest",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function GetGroupLoginRequest(Request $request){
        $rules = array(
            'group_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $get =  LoginInGroupRequest::with('LoginInGroupRequest')->where('group_id', $request->group_id)->orderBy('id', 'desc')->get();
        return response()->json([
           'status' => true,
           'data' => $get
        ],200);
    }

    /**
     * @OA\Post(
     * path="api/LoginInGroupRequest",
     * summary="LoginInGroupRequest",
     * description="LoginInGroupRequest",
     * operationId="LoginInGroupRequest",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="LoginInGroupRequest",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="group_id", type="string",format="text", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="LoginInGroupRequest",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function LoginInGroupRequest(Request $request){
        $rules = array(
            'group_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $get = Group::where('id', $request->group_id)->first();


        if($get == null){
            return response()->json([
               'status' => false,
               'message' => 'wrong Group Id'
            ],422);
        }
        if($get->HideGroup == 'true'){
          
            GroupUser::create([
                 'group_id' => $request->group_id,
                 'user_id' => auth()->user()->id,
                 'status' => 'user'
            ]);
            return response()->json([
               'status' => true,
               'message' => 'User Logined in group'
            ],200);
        }


        $getGroup = LoginInGroupRequest::where(['sender_id' => auth()->user()->id,
            'group_id' => $request->group_id])->get();

        if(!$getGroup->isEMpty()){
            $getGroup = LoginInGroupRequest::where([    'sender_id' => auth()->user()->id,
                'group_id' => $request->group_id])->delete();
            return response()->json([
                'status' => true,
                'message' => 'request Deleted'
            ],200);
        }
        else{
            LoginInGroupRequest::create([
                'sender_id' => auth()->user()->id,
                'group_id' => $request->group_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Request Created'
            ],200);
        }



    }


    /**
     * @OA\Post(
     * path="api/groupSettings",
     * summary="groupSettings",
     * description="groupSettings",
     * operationId="groupSettings",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="groupSettings",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="group_id", type="string",format="text", example="1"),
     *               @OA\Property(property="name", type="string",format="text", example="name"),
     *               @OA\Property(property="commentStatus", type="string",format="commentStatus", example="True Or False"),
     *               @OA\Property(property="audioStatus", type="string",format="audioStatus", example="True Or False"),
     *               @OA\Property(property="VideoStatus", type="string",format="VideoStatus", example="True Or False"),
     *               @OA\Property(property="HideGroup", type="string",format="HideGroup", example="True Or False"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="groupSettings",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function groupSettings(Request $request){
        $rules = array(
            'group_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $group =Group::where('id', $request->group_id);

        if(isset($request->name)){
            $group->update([
                'name' => $request->name
            ]);
        }

        if(isset($request->commentStatus)){

            $group->update([
                'commentStatus' => $request->commentStatus,
            ]);
        }

        if (isset($request->audioStatus)){
            $group->update([
                'audioStatus' => $request->audioStatus,
            ]);
        }

        if(isset($request->VideoStatus)){
            $group->update([
                'VideoStatus' => $request->VideoStatus
            ]);
        }

        if(isset($request->HideGroup)){
            $group->update([
                'HideGroup' => $request->HideGroup
            ]);
        }







        return response()->json([
           'status' => true,
           'message' => 'Group Updated'
        ]);
    }


    /**
     * @OA\Post(
     * path="api/BlackListStatusInGroupAndDelete",
     * summary="BlackListStatusInGroupAndDelete",
     * description="BlackListStatusInGroupAndDelete",
     * operationId="BlackListStatusInGroupAndDelete",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="groupSettings",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="group_id", type="string",format="text", example="1"),
     *               @OA\Property(property="user_id", type="string",format="text", example="1"),
     *               @OA\Property(property="delete", type="string",format="delete", example="true or false"),
     *               @OA\Property(property="addBlackList", type="string",format="addBlackList", example="true or false"),
     *               @OA\Property(property="deleteBlackList", type="string",format="addBlackList", example="true or false"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="BlackListStatusInGroupAndDelete",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function BlackListStatusInGroupAndDelete(Request $request){
        $rules = array(
            'group_id' => 'required',
            'user_id' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $user =  GroupUser::where('user_id',$request->user_id)->where('group_id', $request->group_id);


        if(isset($request->delete)&& $request->delete == true){
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'user Deleted'
            ],200);
        }

        if(isset($request->addBlackList) && $request->addBlackList == true){
            $user->update([
                'status' => 'BlackList'
            ]);
            return response()->json([
                'status' => true,
                'message' => 'user added Black List'
            ],200);
        }
        if(isset($request->deleteBlackList) && $request->deleteBlackList == true){
            $user->update([
                'status' => 'user'
            ]);
            return response()->json([
                'status' => true,
                'message' => 'user deleted Black List'
            ],200);
        }

    }

    /**
     * @OA\Post(
     * path="api/UserAddNewModeradorAnDelete",
     * summary="UserAddNewModeradorAnDelete",
     * description="UserAddNewModeradorAnDelete",
     * operationId="UserAddNewModeradorAnDelete",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="UserAddNewModeradorAnDelete",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="group_id", type="string",format="text", example="1"),
     *               @OA\Property(property="user_id", type="string",format="text", example="1"),
     *               @OA\Property(property="moderator", type="string",format="text", example="true or false"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="UserAddNewModeradorAnDelete",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function UserAddNewModeradorAnDelete(Request $request){
        $rules = array(
            'group_id' => 'required',
            'user_id' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        if($request->moderator == 'true'){
            GroupUser::where('user_id', $request->user_id)->where('group_id', $request->group_id)->update([
                'status' => 'moderator'
            ]);
        }

        if($request->moderator == 'false'){
            GroupUser::where('user_id', $request->user_id)->where('group_id', $request->group_id)->update([
                'status' => 'user'
            ]);
        }

        return response()->json([
           'status' => true,
           'message' => 'user Added Moderator'
        ],200);


    }

    /**
     * @OA\Post(
     * path="api/LogoutInGroup",
     * summary="LogoutInGroup",
     * description="LogoutInGroup",
     * operationId="LogoutInGroup",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="LogoutInGroup",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="group_id", type="string",format="text", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="LogoutInGroup",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function LogoutInGroup(Request $request){
        $rules = array(
            'group_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        GroupUser::where('group_id', $request->group_id)->where('user_id', auth()->user()->id)->delete();


        return response()->json([
           'status' => true,
           'message' => 'User Logouted is Group'
        ],200);
    }

    public function index()
    {
        $data = Groupmember::where('receiver_id', auth()->user()->id)
            ->where('user_status', 'unconfirm')
            ->with('sender','groupmembers')->orderBy('id', 'Desc')
            ->get();


        if(!$data ->isempty()){
            foreach ($data as $item){
                $array[] = [
                    'user_id' =>$item->sender->id,
                    'user_name' =>  $item->sender->name,
                    'user_surname' =>  $item->sender->surname,
                    'request_id' => $item->id,
                    'group_name' =>$item->groupmembers->name,
                    'group_image' => $item->groupmembers->image,
                    'group_id' => $item->groupmembers->id
                ];
            }
        }else{
            $array = [];
        }



        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'sent you a request',
                'NewData' => $array
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ]);
        }
    }

    public function YourGroup(Request $request)
    {
//        $MyGroup = Group::where('user_id', auth()->user()->id)->where('deleted_at',  null)->get();
//        $user = Groupmember::where('receiver_id', auth()->user()->id)
//            ->where('user_status', 'true')
//            ->with('group')
//            ->get();

        $group = GroupUser::where('user_id', auth()->user()->id)->with('Group')->whereRelation('Group','deleted_at', null )->get();


        if ($group->isEMpty()) {
            return response()->json([
                'success' => false,
                'message' => 'you dont have a group'
            ]);
        } else {
            return response()->json([
                'success' => true,
//                'OtherGroup' => $user,
                'Group' => $group,
//                'MyGroup' => $MyGroup
            ]);
        }
    }

    /**
     * @OA\Post(
     * path="api/create-group",
     * summary="Group created successfully",
     * description="Group created successfully",
     * operationId="Groups created successfully",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Group created successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="name", type="string",format="text", example="some"),
     *               @OA\Property(property="image", type="file",format="file", example="1"),
     *               @OA\Property(property="Users[]", type="string",format="string", example="1"),
     *               @OA\Property(property="HideGroup", type="string",format="string", example="True Or False"),
     *               @OA\Property(property="CreatedAt", type="string",format="string", example="True Or False"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Group created successfully",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $rules = array(
            'image' => 'required|image',
            'name' => 'required|max:254',
            'HideGroup' => 'required',
            'CreatedAt' => 'required',

        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $image = $request->file('image');
        if ($image) {
            $destinationPath = 'uploads';
            $user_image = time() . $image->getClientOriginalName();
            $image->move($destinationPath, $user_image);
        } else {
            $user_image = null;
        }

        $createGroups = [
            'name' => $request->name,
            'user_id' => auth()->user()->id,
            'image' => $user_image,
            'CreatedAt' => $request->CreatedAt,
            'HideGroup' => $request->HideGroup,
        ];
        $data = Group::create($createGroups);


        if (isset($request->Users )){
            foreach ($request->Users as $user) {
                Groupmember::create([
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $user,
                    'group_id' => $data->id,
                    'status' => 'open',
                    'user_status' => 'unconfirm'
                ]);
            }
        }

        GroupUser::create([
           'group_id' => $data->id,
           'user_id' => auth()->user()->id,
            'status' => 'GeneralAdmin'
        ]);
        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'group successfully created',
                'group_id' => $data->id
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
     * path="api/AddMyAnswerInLoginGroup",
     * summary="AddMyAnswerInLoginGroup",
     * description="AddMyAnswerInLoginGroup",
     * operationId="AddMyAnswerInLoginGroup",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Moderator created successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="GroupInviteId", type="integer",format="GroupInviteId", example=1),
     *               @OA\Property(property="Answer", type="Answer",format="Answer", example="true or false"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Moderator created successfully",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function AddMyAnswerInLoginGroup(Request $request){
        $rules = array(
            'GroupInviteId' => 'required',
            'Answer' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $invirte_id = $request->GroupInviteId;
        if($request->Answer == true){
            $groupMember =  Groupmember::where('id', $invirte_id)->first();
            if($groupMember == null){
                return response()->json([
                   'status' => false,
                   'message' => 'wrong InviteId'
                ],422);
            }else{
                GroupUser::create([
                   'user_id' => auth()->user()->id,
                    'group_id' => $groupMember->group_id,
                    'status' => 'user'
                ]);
                Groupmember::where('id', $invirte_id)->delete();
                return response()->json([
                   'status' => true,
                   'message' => 'Added In group'
                ],200);
            }

        }elseif($request->Answer == false){
            Groupmember::where('id', $invirte_id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'User cancaled Request'
            ],200);
        }else{
            return response()->json([
               'status' => false,
               'message' => 'Answer No true Or False'
            ],422);
        }
    }


    /**
     * @OA\Post(
     * path="api/GetUserFromInviteGroup",
     * summary="GetUserFromInviteGroup",
     * description="GetUserFromInviteGroup",
     * operationId="GetUserFromInviteGroup",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Moderator created successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="groupId", type="integer",format="groupId", example=1),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="GetUserFromInviteGroup",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public  function GetUserFromInviteGroup(Request $request){

        $groupId = $request->groupId;
        $data = Friend::where('receiver_id', auth()->user()->id)->where('status', 'true')
            ->OrWhere('sender_id',auth()->user()->id)->where('status', 'true')->get(['sender_id','receiver_id']);

     if(!$data->isEMpty()){
         foreach ($data as $user ){
             if($user->sender_id == auth()->user()->id){
                 $userArray[] = $user->receiver_id;
             }else{
                 $userArray[] = $user->sender_id;
             }
         }
     }else{
         $userArray = [];
     }


        $getGroupUser = GroupUser::where('group_id', $groupId)->wherein('user_id', $userArray)->get('user_id');


        if(!$getGroupUser->isEMpty()){
            foreach ($getGroupUser as $getGroupUser2 ){
                    $userArray2[] = $getGroupUser2->user_id;
            }
        }else{
            $userArray2 = [];
        }

        $groupMembers = Groupmember::whereIn('receiver_id',$userArray)->where('group_id', $groupId)->get('receiver_id')->toarray();
        $GroupLoginrequest = LoginInGroupRequest::where('sender_id', $userArray )->where('group_id', $groupId)->get('sender_id')->toarray();

        $user = User::with(['receivergroup' => function ($query) use ($groupId){
            $query->where('group_id',$groupId);
        } ])->wherenotin('id', $userArray2)
            ->wherenotin('id', $groupMembers)
            ->wherenotin('id', $GroupLoginrequest)
            ->wherein('id', $userArray)
            ->OrderBy('name','asc')->get();



        return response()->json([
           'status' => true,
           'data' => $user
        ],200);

    }

    /**
     * @OA\Post(
     * path="api/GetGroupFromFriendMember",
     * summary="GetGroupFromFriendMember",
     * description="GetGroupFromFriendMember",
     * operationId="GetGroupFromFriendMember",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Moderator created successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="user_id", type="integer",format="user_id", example=1),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="GetGroupFromFriendMember",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function GetGroupFromFriendMember(Request $request){
        $getGroupsId = GroupUser::where('user_id', auth()->user()->id)->where('user_id', '!=', $request->user_id)->get('group_id')->toarray();
        $groupMembers = Groupmember::where('receiver_id', $request->user_id)->get('group_id')->toarray();
        $groupLogin = LoginInGroupRequest::where('sender_id', $request->user_id)->get('group_id')->toarray();
        $getGroups = Group::whereNOtIn('id', $groupMembers)->where('deleted_at', null)->whereNotIn('id',$groupLogin)->whereIn('id', $getGroupsId)->where('user_id', '!=',$request->user_id)->get();

        return response()->json([
           'status' => true,
           'data' => $getGroups
        ],200);

    }
    /**
     * @OA\Post(
     * path="api/AddInviteGetGroupFromFriend",
     * summary="AddInviteGetGroupFromFriend",
     * description="AddInviteGetGroupFromFriend",
     * operationId="AddInviteGetGroupFromFriend",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Moderator created successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="user_id", type="integer",format="user_id", example=1),
     *               @OA\Property(property="groups_id[]", type="integer",format="groups_id[]", example=1),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="AddInviteGetGroupFromFriend",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function AddInviteGetGroupFromFriend(Request $request){
               $user_id = $request->user_id;
            foreach ($request->groups_id as $group) {
                Groupmember::create([
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $user_id,
                    'group_id' => $group,
                    'user_status' => 'unconfirm'
                ]);
            }
            return response()->json([
               'status' => true,
               'message' => 'invite Created'
            ], 200);
    }

    /**
     * @OA\Post(
     * path="api/AddInviteGetGroupFromFriends",
     * summary="AddInviteGetGroupFromFriends",
     * description="AddInviteGetGroupFromFriends",
     * operationId="AddInviteGetGroupFromFriends",
     * tags={"Groups"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Moderator created successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="Users[]", type="integer",format="Users", example=1),
     *               @OA\Property(property="group_id", type="integer",format="group_id", example=1),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="AddInviteGetGroupFromFriends",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function AddInviteGetGroupFromFriends(Request $request){

        $group_id = $request->group_id;

        foreach ($request->Users as $user_id) {

            Groupmember::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $user_id,
                'group_id' => $group_id,
                'user_status' => 'unconfirm'
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'invite Created'
        ], 200);
    }



    /**
     * @OA\Post(
     * path="api/create-moderator",
     * summary="Moderator created successfully",
     * description="Moderator created successfully",
     * operationId="Moderators created successfully",
     * tags={"Group Moderator"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Moderator created successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="receiver_id", type="integer",format="integer", example=1),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Moderator created successfully",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function ModeratorCreate(Request $request)
    {
        $isAdmin = Group::where('user_id', auth()->user()->id)->get();

        if (!$isAdmin->isEmpty()) {
            $createModerator = Groupmember::where('receiver_id', $request->moderator_id)
                ->update(['role' => 'moderator']);

            if ($createModerator) {
                return response()->json([
                    'success' => true,
                    'message' => 'moderator successfully assigned'
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'something was wrong'
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'you are not an administrator'
            ], 422);
        }
    }

    /**
     * @OA\Post(
     * path="api/admin-update-posts",
     * summary="Admin updated successfully",
     * description="Admin updated successfully",
     * operationId="Admin updated successfully",
     * tags={"Group Admin"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Admins updated successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="post_id", type="integer",format="integer", example=1),
     *               @OA\Property(property="description", type="string",format="string", example="some text"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Admin updated successfully",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function updatePosts(Request $request)
    {
        $isAdmin = Group::where('user_id', auth()->user()->id)->get();

        if (!$isAdmin->isEmpty()) {

            $group = Post::where('id', $request->post_id)->first();

            if ($isAdmin[0]->id == $group['group_id']) {
                if (isset($request->description)) {
                    $update = Post::where('id', $request->post_id)->update(['description' => $request->description]);
                    if ($update) {
                        return response()->json([
                            'success' => true,
                            'message' => 'post description successfully updated'
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'something was wrong'
                        ], 422);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'something was wrong'
                    ], 422);
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'you are not an administrator'
            ], 422);
        }
    }

    /**
     * @OA\Post(
     * path="api/admin-delete-posts",
     * summary="Post deleted successfully",
     * description="Post deleted successfully",
     * operationId="Post deleted successfully",
     * tags={"Group Admin"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Post deleted successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="post_id", type="integer",format="integer", example=1),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Post deleted successfully",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function deletePosts(Request $request)
    {
        $isAdmin = Group::where('user_id', auth()->user()->id)->get();

        if (!$isAdmin->isEmpty()) {

            $group = Post::where('id', $request->post_id)->first();

            if ($isAdmin[0]->id == $group['group_id']) {
                $delete = Post::where('id', $request->post_id)->delete();
                if ($delete) {
                    return response()->json([
                        'success' => true,
                        'message' => 'post successfully deleted'
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'something was wrong'
                    ], 422);
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'you are not an administrator'
            ], 422);
        }
    }

    /**
     * @OA\Post(
     * path="api/moderator-update-posts",
     * summary="Post updated successfully",
     * description="Post updated successfully",
     * operationId="Post updated successfully",
     * tags={"Group Moderator"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Posts updated successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="post_id", type="integer",format="integer", example=1),
     *               @OA\Property(property="description", type="string",format="string", example="some text"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Posts updated successfully",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function ModeratotupdatePosts(Request $request)
    {
        $isModerator = Groupmember::where('receiver_id', auth()->user()->id)->where('role', 'moderator')->get();

        if (!$isModerator->isEmpty()) {
            $group = Post::where('id', $request->post_id)->first();

            if ($isModerator[0]->group_id == $group['group_id']) {
                if (isset($request->description)) {
                    $update = Post::where('id', $request->post_id)->update(['description' => $request->description]);
                    if ($update) {
                        return response()->json([
                            'success' => true,
                            'message' => 'post description successfully updated'
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'something was wrong'
                        ], 422);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'something was wrong'
                    ], 422);
                }
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
     * path="api/moderator-delete-posts",
     * summary="Postsss deleted successfully",
     * description="Postsss deleted successfully",
     * operationId="Postsss deleted successfully",
     * tags={"Group Moderator"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Postss deleted successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="post_id", type="integer",format="integer", example=1),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Postsss deleted successfully",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function ModeratordeletePosts(Request $request)
    {
        $isModerator = Groupmember::where('receiver_id', auth()->user()->id)->get();

        if (!$isModerator->isEmpty()) {

            $group = Post::where('id', $request->post_id)->first();

            if ($isModerator[0]->group_id == $group['group_id']) {
                $delete = Post::where('id', $request->post_id)->delete();
                if ($delete) {
                    return response()->json([
                        'success' => true,
                        'message' => 'post successfully deleted'
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'something was wrong'
                    ], 422);
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'you are not an administrator'
            ], 422);
        }
    }

    /**
     * @OA\Get(
     * path="api/admin-delete-user",
     * summary="User deleted successfully",
     * description="User deleted successfully",
     * operationId="User deleted successfully",
     * tags={"Group Admin"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User deleted successfully",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="id", type="integer",format="integer", example=1),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="User deleted successfully",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function AdminDeleteUsers($id)
    {
        $isAdmin = Group::where('user_id', auth()->user()->id)->get();

        if (!$isAdmin->isEmpty()) {

            $deleteUsers = Groupmember::where('user_id', $id)->delete();

            if ($deleteUsers) {
                return response()->json([
                    'success' => true,
                    'message' => 'user successfully deleted on group'
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
     * path="api/update-group-name",
     * summary="group name successfully changed",
     * description="group name successfully changed",
     * operationId="group name successfully changed",
     * tags={"Group Admin"},
     * @OA\RequestBody(
     *    required=true,
     *    description="group name successfully changed",
     *    @OA\JsonContent(
     *               required={"true"},
     *               @OA\Property(property="id", type="integer",format="integer", example=1),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="group name successfully changed",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function UpdateGroup(Request $request)
    {
        $isAdmin = Group::where('user_id', auth()->user()->id)->get();

        if (!$isAdmin->isEmpty()) {
            if ($request->name) {
                $updateGroupName = Group::where('user_id', auth()->user()->id)->update(['name' => $request->name]);
                if ($updateGroupName) {
                    return response()->json([
                        'success' => true,
                        'message' => 'group name successfully changed'
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'something was wrong'
                    ], 422);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong'
                ], 422);
            }
        }
    }

    /**
     * @OA\Get(
     * path="api/delete-group",
     * summary="group successfully deleted",
     * description="group successfully deleted",
     * operationId="group successfully deleted",
     * tags={"Group Admin"},
     * @OA\RequestBody(
     *    required=true,
     *    description="group successfully deleted",
     *    @OA\JsonContent(
     *               required={"true"},
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="group successfully deleted",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function deleteGroup()
    {
        $isAdmin = Group::where('user_id', auth()->user()->id)->get();

        if (!$isAdmin->isEmpty()) {
            $deleteGroup = Group::where('user_id', auth()->user()->id)->delete();
            if ($deleteGroup) {
                return response()->json([
                    'success' => true,
                    'message' => 'group successfully deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong'
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ], 422);
        }
    }

    /**
     * @OA\Post(
     * path="api/delete-moderator",
     * summary="moderator successfully deleted",
     * description="moderator successfully deleted",
     * operationId="moderator successfully deleted",
     * tags={"Group Admin"},
     * @OA\RequestBody(
     *    required=true,
     *    description="moderator successfully deleted",
     *    @OA\JsonContent(
     *               required={"true"},
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="moderator successfully deleted",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


    public function DeleteModerator(Request $request)
    {
        $isAdmin = Group::where('user_id', auth()->user()->id)->get();

        if (!$isAdmin->isEmpty()) {
            if ($request->receiver_id) {
                $updateGroupName = Groupmember::where('receiver_id', $request->receiver_id)->update(['role' => 'participant']);
                if ($updateGroupName) {
                    return response()->json([
                        'success' => true,
                        'message' => 'moderator successfully deleted'
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'something was wrong'
                    ], 422);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong'
                ], 422);
            }
        }
    }
}
