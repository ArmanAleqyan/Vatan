<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
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
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong'
                ], 422);
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
}
