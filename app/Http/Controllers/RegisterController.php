<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function index()
    {
        return view('registration');
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        if ($request->email) {
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'patronymic' => $request->patronymic,
                'city' => $request->city,
                'username' => $request->username,
                'date_of_birth' => $request->date_of_birth,
            ]);
            return redirect()->route('login');
        } else {
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'patronymic' => $request->patronymic,
                'city' => $request->city,
                'username' => $request->username,
                'date_of_birth' => $request->date_of_birth,
            ]);
            return redirect()->route('login');
        }

    }
}
