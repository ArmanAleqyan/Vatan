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
            return response()->json([
                'success' => true,
                'message' => 'user successfully registered'
            ], 200);
        } else {
            $number = $request->number;

            $call_number = preg_replace('/[^0-9]/', '', $number);
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'number' => $call_number,
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
            return response()->json([
                'success' => true,
                'message' => 'user successfully registered'
            ], 200);
        }
    }
}
