<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use GreenSMS\GreenSMS;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    public function index()
    {
        return view('registration');
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        $randomNumber = random_int(100000, 999999);
        if ($request->email) {
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'verify_code' => $randomNumber,
                'password' => Hash::make($request->password),
                'patronymic' => $request->patronymic,
                'city' => $request->city,
                'username' => $request->username,
                'date_of_birth' => $request->date_of_birth,
            ]);
            if ($user) {
                $details = [
                    'email' => $user->email,
                    'verification_at' => $randomNumber,
                ];
            }

            Mail::to($user->email)->send(new SendMail($details));
            return redirect()->route('login');
        } else {
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'number' => $request->number,
                'verify_code' => $randomNumber,
                'password' => Hash::make($request->password),
                'patronymic' => $request->patronymic,
                'city' => $request->city,
                'username' => $request->username,
                'date_of_birth' => $request->date_of_birth,
            ]);
            if ($user) {
                $client = new GreenSMS([
                    'user' => 'sadn',
                    'pass' => 'Dgdhh378qq',

                ]);

                $response = $client->sms->send([
                    'to' => $request->number,
                    'txt' => 'Here is your message for delivery'
                ]);

            }
            return redirect()->route('login');
        }
    }
}
