<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RessetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RessetpasswordMail;


class ForgotController extends Controller
{
    /**
     * @OA\Post(
     * path="api/code-sending",
     * summary="User Send Email",
     * description="User Send Email",
     * operationId="User Send Email",
     * tags={"Forgot-password"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Send Email",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="email", type="email", format="email", example="test@gmail.com"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function send(Request $request)
    {
        if ($request->email) {
            $email_exist = User::where(['email' => $request->email,])->get();
            if (!$email_exist->isEmpty()) {

                $randomNumber = random_int(100000, 999999);
                $user_id = $email_exist[0]->id;


                $details = [
                    'title' => 'Mail from Vatan',
                    'code' => $randomNumber,
                    'body' => 'This is for forggot password'
                ];

//            Mail::to($request->email)->send(new RessetpasswordMail($details));

                $code = RessetPassword::create([
                    "user_id" => $user_id,
                    "random_int" => $randomNumber,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'code os sended to your email'
                ], 200);

            }
//            if (!$email_exist->isEmpty()) {
//
//                $randomNumber = random_int(100000, 999999);
//                $user_id = $email_exist[0]->id;
//
//                $details = [
//                    'title' => 'Mail from Vatan',
//                    'code' => $randomNumber,
//                    'body' => 'This is for forggot password'
//                ];
//
////            Mail::to($request->email)->send(new RessetpasswordMail($details));
//
//                $code = RessetPassword::create([
//                    "user_id" => $user_id,
//                    "random_int" => $randomNumber,
//                ]);
//                return response()->json([
//                    'success' => true,
//                    'message' => 'code os sended to your email'
//                ], 200);
//
//            }
        }
        if ($request->number) {
            $email_exist = User::where(['number' => $request->number,])->get();
            if (!$email_exist->isEmpty()) {

                $randomNumber = random_int(100000, 999999);
                $user_id = $email_exist[0]->id;

                $details = [
                    'title' => 'Mail from Vatan',
                    'code' => $randomNumber,
                    'body' => 'This is for forggot password'
                ];

            Mail::to($request->email)->send(new RessetpasswordMail($details));

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
                    'title' => 'Mail from Vatan',
                    'code' => $randomNumber,
                    'body' => 'This is for forggot password'
                ];

            Mail::to($request->email)->send(new RessetpasswordMail($details));

                $code = RessetPassword::create([
                    "user_id" => $user_id,
                    "random_int" => $randomNumber,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'code os sended to your number'
                ], 200);

            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'номер не существует !'
            ]);
        }
    }

    /**
     * @OA\Post(
     * path="api/restore-password",
     * summary="restore-password",
     * description="restore-password",
     * operationId="restore-password",
     * tags={"Forgot-password"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="random_int", type="integer", format="integer", example="551485"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


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

    /**
     * @OA\Post(
     * path="api/update-password",
     * summary="update-password",
     * description="update-password",
     * operationId="update-password",
     * tags={"Forgot-password"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="user_id", type="integer", format="integer", example="3"),
     *          @OA\Property(property="password", type="password", format="password", example="1234"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */


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
