<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use   App\Events\ChatNotification;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{


    public function UpdateStatusChat(Request $request){

            $chat = Chat::where('room_id', $request->id)->where('receiver_id', 1)->update([
                'review' => 0
            ]);
    }

    public function getAdminMessageJson(Request $request){



        if(isset($request->search)){
            $search = $request->search;
            Chat::where('receiver_id', 1)->where('sender_id', $request->id)->update([
                'review' => 0
            ]);

            $usersChat = Chat::query()->where(function ($query) {
                $query->where([
                    'sender_id' => 1,
                ])->orWhere([
                    'receiver_id' => 1,
                ]);
            })->whereRelation('user', 'name', 'like', '%'.$request->search.'%')->orwhereRelation('forusers', 'surname', 'like', '%'.$request->search.'%')
                ->whererelation('forusers', 'deleted_at', null)
                ->whererelation('user', 'deleted_at', null)
                ->with('forusers', 'user')
                ->orderBy('created_at','DESC')
                ->get()
                ->groupBy('room_id')
                ->toArray();


        }else{
            Chat::where('receiver_id', 1)->where('sender_id', $request->id)->update([
                'review' => 0
            ]);
            $usersChat = Chat::query()->where(function ($query) {
                $query->where([
                    'sender_id' => 1,
                ])->orWhere([
                    'receiver_id' => 1,
                ]);
            })
                ->whererelation('forusers', 'deleted_at', null)
                ->whererelation('user', 'deleted_at', null)
                ->with('user', 'forusers')
                ->orderBy('created_at','DESC')
                ->get()
                ->groupBy('room_id')
                ->toArray();
        }

        if($usersChat != []){
            foreach ($usersChat as $item) {
                $user_name = 1 == $item[0]['forusers']['id'] ? $item[0]['user']['name'] : $item[0]['forusers']['name'];
                $receiver_id = 1 == $item[0]['forusers']['id'] ? $item[0]['user']['id'] : $item[0]['forusers']['id'];
                $surname = 1 == $item[0]['forusers']['id'] ? $item[0]['user']['surname'] : $item[0]['forusers']['surname'];
                $room_id =  $item[0]['room_id'];
                $user_image = 1 == $item[0]['forusers']['id'] ? $item[0]['user']['avatar'] : $item[0]['forusers']['avatar'];
                $FirstMessage = Chat::where('room_id', $room_id)->latest()->first();
                $count  = Chat::where('receiver_id', 1)->where('sender_id', $receiver_id)->sum('review');
                $right_side_data[] = [
                    'user_name' => $user_name,
                    'surname' =>$surname,
                    'message' => $FirstMessage->message,
                    'file' => $FirstMessage->file,
                    'room_id' => $room_id,
                    'user_image' => $user_image,
                    'receiver_id' => $receiver_id,
                    'count' => $count,
                    'time' => $FirstMessage->created_at->diffForHumans()
//                'time' => $FirstMessage->created_at
                ];
            }
        }else{
            $right_side_data = [];
        }


        return response()->json([
           'status' => true,
            'data' => $right_side_data
        ]);
    }

    public function getAdminMessage(){


        if(auth()->user() == null){
            return redirect('https://dev.vatan.su/nova/login');
        }

        $usersChat = Chat::query()->where(function ($query) {
            $query->where([
                'sender_id' => 1,
            ])->orWhere([
                'receiver_id' => 1,
            ]);
        })
            ->whererelation('forusers', 'deleted_at', null)
            ->whererelation('user', 'deleted_at', null)
            ->with('user', 'forusers')
            ->orderBy('created_at','DESC')
            ->get()
            ->groupBy('room_id')
            ->toArray();
           ;
        foreach ($usersChat as $item) {

            $user_name = 1 == $item[0]['forusers']['id'] ? $item[0]['user']['name'] : $item[0]['forusers']['name'];
            $receiver_id = 1 == $item[0]['forusers']['id'] ? $item[0]['user']['id'] : $item[0]['forusers']['id'];
            $surname = 1 == $item[0]['forusers']['id'] ? $item[0]['user']['surname'] : $item[0]['forusers']['surname'];
            $room_id =  $item[0]['room_id'];
            $user_image = 1 == $item[0]['forusers']['id'] ? $item[0]['user']['avatar'] : $item[0]['forusers']['avatar'];
            $FirstMessage = Chat::where('room_id', $room_id)->latest()->first();
            $count  = Chat::where('receiver_id', 1)->where('sender_id', $receiver_id)->sum('review');
            $right_side_data[] = [
                'user_name' => $user_name,
                'surname' =>$surname,
                'message' => $FirstMessage->message,
                'file' => $FirstMessage->file,
                'room_id' => $room_id,
                'user_image' => $user_image,
                'receiver_id' => $receiver_id,
                'count' => $count,
                'time' => $FirstMessage->created_at->diffForHumans()
//                'time' => $FirstMessage->created_at
            ];
        }
        return view('chat', compact('right_side_data'));
    }




    public function getRoomChat(Request $request){

        Chat::where('room_id', $request->room_id)->where('receiver_id', 1)->update([
            'review' => 0
        ]);
        $chat = Chat::where('room_id', $request->room_id)->get();


        return response()->json([
           'status' => true,
           'data' => $chat
        ]);
    }

    public function SendAdminMessage(Request $request){


        $get_chat = Chat::where('receiver_id', $request->receiver_id)->where('sender_id', 1)->first();
        if ($get_chat == null) {
            $get_chat2 = Chat::where('receiver_id', 1)->where('sender_id', $request->receiver_id)->first();
            if ($get_chat2 == null) {
                $room_id = time();
            } else {
                $room_id = $get_chat2->room_id;
            }
        } else {
            $room_id = $get_chat->room_id;
        }


        if(isset($request->file)){
            $time = time();
            foreach ($request->file as $file) {
                $destinationPath = 'uploads';
                $originalFile = $time++ . $file->getClientOriginalName();
                $file->move($destinationPath, $originalFile);
                $file = $originalFile;
                $data = [
                    'sender_id' => 1,
                    'receiver_id' => $request->receiver_id,
                    'file' => $file,
                    'notification' => 0,
                    'room_id' => $room_id,
                    'messages' => $request->messages
                ];

                $chat[] = Chat::create($data);

            }
        }
//        $fileNames = array_keys($request->allFiles());
//        $data = $request->except($fileNames);
//        $fileNames = array_keys($request->allFiles());
//        if (count($fileNames)) {
//            foreach ($fileNames as $fileName) {
//                $image = $request->file($fileName);
//                $destinationPath = 'public/uploads';
//                $originalFile = time() . $image->getClientOriginalName();
//                $data = [
//                    'sender_id' => 1,
//                    'receiver_id' => $request->receiver_id,
//                    'messages' => $request->messages,
//                    'notification' => 0,
//                    'room_id' => $room_id,
//                    'file' => $originalFile,
//                ];
//            }
//        }
        else {
            $data = [
                'sender_id' => 1,
                'receiver_id' => $request->receiver_id,
                'messages' => $request->messages,
                'notification' => 0,
                'room_id' => $room_id,
                'file' => null
            ];
            $chat[] = Chat::create($data);
        }


        $getCount = Chat::where('sender_id', auth()->user()->id)->where('receiver_id',$request->receiver_id)->sum('review');
        $lattestMessage = Chat::where('sender_id', auth()->user()->id)->where('receiver_id',$request->receiver_id)->latest()->first();


        $lattestMessage['notification'] = $lattestMessage->created_at->diffForHumans();

        if ($chat) {
            $chat_data = Chat::where("receiver_id", $request->receiver_id)->where("sender_id", 1)->get();
            foreach ($chat_data as $chat_datum)
                if ($chat_datum->receiver_id == auth()->id()) {
                    $chat_datum->receiver_id = $chat_data->sender_id;
                    $chat_datum->sender_id = auth()->id();
                }
            $user = auth()->user();
            $receiverUser = User::where('id', $chat_datum->receiver_id)->get();
            event(new ChatNotification($chat, $receiverUser, auth()->user(),$getCount,$lattestMessage->created_at->diffForHumans()));
            return response()->json([
                "success" => true,
                "message" => "your message has been successfully sent",
                "data" => [
                    'message' =>  'message created',
                    'chat' =>$chat
//                    "message" => $chat,
//                    "sender" => $user,
//                    "receiver" => $receiverUser,
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ]);
        }

    }

}
