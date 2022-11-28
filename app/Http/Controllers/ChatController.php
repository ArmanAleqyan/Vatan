<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Events\ChatNotification;


class ChatController extends Controller
{
    public function store(Request $request)
    {
        $get_chat = Chat::where('receiver_id', $request->receiver_id)->where('sender_id', auth()->user()->id)->first();

        if ($get_chat == null) {
            $get_chat2 = Chat::where('receiver_id', auth()->user()->id)->where('sender_id', $request->receiver_id)->first();
            if ($get_chat2 == null) {
                $room_id = time();
            } else {
                $room_id = $get_chat2->room_id;
            }
        } else {
            $room_id = $get_chat->room_id;
        }

        $fileNames = array_keys($request->allFiles());
        $data = $request->except($fileNames);
        $fileNames = array_keys($request->allFiles());
        if (count($fileNames)) {
            foreach ($fileNames as $fileName) {
                $image = $request->file($fileName);
                $destinationPath = 'public/uploads';
                $originalFile = time() . $image->getClientOriginalName();
                $data = [
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $request->receiver_id,
                    'messages' => $request->messages,
                    'notification' => 0,
                    'room_id' => $room_id,
                    'file' => $originalFile,
                ];
            }
        } else {
            $data = [
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->receiver_id,
                'messages' => $request->messages,
                'notification' => 0,
                'room_id' => $room_id,
            ];
        }

        $chat = Chat::create($data);


        if ($chat) {

            $chat_data = Chat::where("receiver_id", $request->receiver_id)->where("sender_id", auth()->user()->id)->get();

            foreach ($chat_data as $chat_datum)
                if ($chat_datum->receiver_id == auth()->id()) {
                    $chat_datum->receiver_id = $chat_data->sender_id;
                    $chat_datum->sender_id = auth()->id();
                }
            $user = auth()->user();
            $receiverUser = User::where('id', $chat_datum->receiver_id)->get();
            event(new ChatNotification($chat, $receiverUser, auth()->user()));


            return response()->json([
                "success" => true,
                "message" => "your message has been successfully sent",
                "data" => [
                    "message" => $chat,
                    "sender" => $user,
                    "receiver" => $receiverUser,
//                    'receiver_id' => $chat_datum->receiver_id,
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ], 422);
        }
    }

    public function RightSiteUsers()
    {
        $usersChat = Chat::query()->where(function ($query) {
            $query->where([
                'sender_id' => auth()->id(),
            ])->orWhere([
                'receiver_id' => auth()->id(),
            ]);
        })
            ->with(['user', 'forusers'])
            ->orderByDesc('created_at')
            ->get()
            ->unique('room_id')
            ->toArray();
        $right_side_data = [];

        foreach ($usersChat as $item) {

            $review_count = collect($item);
            $user_name = auth()->id() == $item['forusers']['id'] ? $item['user']['name'] : $item['forusers']['name'];
            $receiver_id = auth()->id() == $item['forusers']['id'] ? $item['user']['id'] : $item['forusers']['id'];
            $user_image = auth()->id() == $item['forusers']['id'] ? $item['user']['avatar'] : $item['forusers']['avatar'];
            $image = $item['file'];
            $review = $review_count->sum('review');

            $messages = $item["messages"];
            $et_message = Chat::where('receiver_id', $receiver_id)->where('room_id', $item['room_id'])->sum('review');


            $right_side_data[] = [
                'user_name' => $user_name,
                'user_image' => $user_image,
                'messages' => $messages,
                'image' => $image,
                'receiver_id' => $receiver_id,
                'review' => $review,
                'count' => $et_message,
                'room_id' => $item['room_id'],
            ];
        }
        return response()->json([
            'success' => true,
            'userschatdata' => $right_side_data,
        ], 200);
    }

    public function getUsersData(Request $request, $receiver_id)
    {
        $data = Chat::where(function ($query) use ($receiver_id) {
            $query->where([
                'sender_id' => auth()->id()
            ])->where('receiver_id', $receiver_id)
                ->orWhere([
                    'receiver_id' => auth()->id(),
                ])->where('sender_id', $receiver_id);
        })
            ->with(['user', 'forusers'])
            ->orderBy('id', 'ASC')
            ->get();


        $get_views = Chat::where('review', 1, 'room_id', $request->room_id, 'receiver_id', \auth()->id())
            ->get();


        $ids = [];
        foreach ($get_views as $review_id) {
            array_push($ids, $review_id->id);
            $update_views = Chat::where(['id' => $review_id->id])
                ->update(['review' => 0]);
        }

        $user = [];
        foreach ($data as $datum) {
            $user[] = User::where('id', $datum->receiver_id)->get();
        }

        if (isset($data[0])) {

            if ($data[0]->receiver_id == auth()->user()->id) {
                $reciver_id = $data[0]->sender_id;
            } else {
                $reciver_id = $data[0]->receiver_id;
            }

            return response([
                'success' => true,
                'sender' => auth()->user(),
                'message' => "chat between two users",
                'data' => $data,
                "receiver_user_data" => $user,
                "receiver_id" => $reciver_id
            ], 200);
        }
    }
}
