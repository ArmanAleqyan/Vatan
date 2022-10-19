<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'email' => 'email|max:255',
            'number' => 'max:255',
            'password' => 'required|min:6'
        ]);

        if ($request->email) {
            if (Auth::attempt($data)) {
                return redirect()->route('profile');
            } else {
                return redirect('/login')->with('login_error', 'неверные данные');
            }
        } else {
            if (Auth::attempt($data)) {
                return redirect()->route('profile');
            } else {
                return redirect('/login')->with('login_error', 'неверные данные');
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
                dd(true);
            }
            if (!$updating) {
                dd(false);
            }
        }
    }
}

