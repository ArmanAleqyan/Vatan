<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HiddenAccountController extends Controller
{
    public function hiddenAccount(Request $request)
    {
        $password = $request->password;
        $user = User::where('id', auth()->user()->id)->first();

        $hash_check = Hash::check($request->password, $user->password);
        if ($hash_check == true) {
            $user_account = User::where('id', auth()->user()->id)->update(['hidden_account' => 'close']);
            return response()->json([
                'success' => true,
                'message' => 'hide your account successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'wrong password'
            ], 422);
        }
    }
}
