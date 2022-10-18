<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

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
}
