<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RessetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotController extends Controller
{
    public function send(Request $request)
    {
        if ($request->email) {
            $email_exist = User::where(['email' => $request->email,])->get();
            if (!$email_exist->isEmpty()) {

                $randomNumber = random_int(100000, 999999);
                $user_id = $email_exist[0]->id;

                $details = [
                    'title' => 'Mail from JustEarn.com',
                    'code' => $randomNumber,
                    'body' => 'This is for forggot password'
                ];

//            Mail::to($email)->send(new RessetpasswordMail($details));

                $code = RessetPassword::create([
                    "user_id" => $user_id,
                    "random_int" => $randomNumber,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'code os sended to your email'
                ], 200);

            }
            if (!$email_exist->isEmpty()) {

                $randomNumber = random_int(100000, 999999);
                $user_id = $email_exist[0]->id;

                $details = [
                    'title' => 'Mail from JustEarn.com',
                    'code' => $randomNumber,
                    'body' => 'This is for forggot password'
                ];

//            Mail::to($email)->send(new RessetpasswordMail($details));

                $code = RessetPassword::create([
                    "user_id" => $user_id,
                    "random_int" => $randomNumber,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'code os sended to your email'
                ], 200);

            }
        }
        if ($request->number) {
            $email_exist = User::where(['number' => $request->number,])->get();
            if (!$email_exist->isEmpty()) {

                $randomNumber = random_int(100000, 999999);
                $user_id = $email_exist[0]->id;

                $details = [
                    'title' => 'Mail from JustEarn.com',
                    'code' => $randomNumber,
                    'body' => 'This is for forggot password'
                ];

//            Mail::to($email)->send(new RessetpasswordMail($details));

                $code = RessetPassword::create([
                    "user_id" => $user_id,
                    "random_int" => $randomNumber,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'code os sended to your number'
                ], 200);

            }
            if (!$email_exist->isEmpty()) {

                $randomNumber = random_int(100000, 999999);
                $user_id = $email_exist[0]->id;

                $details = [
                    'title' => 'Mail from JustEarn.com',
                    'code' => $randomNumber,
                    'body' => 'This is for forggot password'
                ];

//            Mail::to($email)->send(new RessetpasswordMail($details));

                $code = RessetPassword::create([
                    "user_id" => $user_id,
                    "random_int" => $randomNumber,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'code os sended to your number'
                ], 200);

            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'number не существует !'
            ]);
        }
    }

    public function CodeSend(Request $request)
    {
        $updatePassword = RessetPassword::where([
            'random_int' => $request->random_int,
        ])->get();

        if (!$updatePassword->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'you can continue'
            ], 200);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'code is not right'
            ], 422);
        }
    }

    public function updatePassword(Request $request)
    {
        $user_id = $request->user_id;

        $user = User::where('id', '=', $request->user_id)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        $delete = RessetPassword::where(['user_id' => $request->user_id])->delete();

        if ($delete) {
            return response()->json([
                    'status' => true,
                    'message' => 'Ваш пароль успешно изменен!']
            );
        } else {
            return response()->json([
                'status' => false,
                'message', 'Произошла ошибка!',
            ]);
        }
    }
}
