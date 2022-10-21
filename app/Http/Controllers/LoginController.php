<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'email' => 'email|max:255',
            'number' => 'max:255',
            'password' => 'required|min:6'
        ]);

        if ($request->email) {
            if (Auth::attempt($data)) {
                $token = auth()->user()->createToken('API Token')->accessToken;

                return response(['user' => auth()->user(), 'token' => $token], 200);
            } else {
                return response(['error_message' => 'Incorrect Details. Please try again']);
            }
        } else {
            if (Auth::attempt($data)) {
                $token = auth()->user()->createToken('API Token')->accessToken;

                return response(['user' => auth()->user(), 'token' => $token], 200);
            } else {
                return response(['error_message' => 'Incorrect Details. Please try again']);
            }
        }
    }

    public function verify(Request $request)
    {
        $user_code = $request->verified_code;

        $users = User::where('verify_code', '=', $user_code)->get();

        if (!$users->isEmpty()) {

            $user_id = $users[0]->id;

            $updating = User::where('id', '=', $user_id)->update(['verify_code' => 1]);
            if ($updating) {
                return response()->json([
                    'success' => true,
                    'message' => 'user successfully verified'
                ], 200);
            }
            if (!$updating) {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong'
                ], 422);
            }
        }
    }
}
