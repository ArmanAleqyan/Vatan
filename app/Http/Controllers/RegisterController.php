<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use GreenSMS\GreenSMS;
use Illuminate\Support\Facades\Mail;
use Exception;
use Validator;


class RegisterController extends Controller
{
    /**
     * @OA\Post(
     * path="api/registration",
     * summary="User Register",
     * description="User Register here",
     * operationId="Register",
     *
     *
     *
     *
     * tags={"Register"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Register here",
     *    @OA\JsonContent(
     *               required={"name","email", "password", "password_confirmation","surname","patronymic","city","username","date_of_birth","number"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="password_confirmation", type="password"),
     *               @OA\Property(property="surname", type="text"),
     *               @OA\Property(property="patronymic", type="text"),
     *               @OA\Property(property="city", type="text"),
     *               @OA\Property(property="username", type="text"),
     *               @OA\Property(property="date_of_birth", type="datetime"),
     *               @OA\Property(property="number", type="integer"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="User Register here",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        $randomNumber = random_int(100000, 999999);
        if ($request->email) {


            $dateStr = $request->date_of_birth;
            $dateArray = date_parse_from_format('Y-m-d', $dateStr);

            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'role_id' => Role::USER_ID,
                'verify_code' => $randomNumber,
                'password' => Hash::make($request->password),
                'patronymic' => $request->patronymic,
                'city' => $request->city,
                'username' => $request->username,
                'date_of_birth' => $dateStr,
                'day' => $dateArray['day'],
                'mount' => $dateArray['month'],
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
                'message' => 'Register Successfully'
            ], 200);
        } else {
            $rules = array(
                'number' => 'required|min:3|max:64|unique:users',
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $validator->errors();
            }

            $dateStr = $request->date_of_birth;
            $dateArray = date_parse_from_format('Y-m-d', $dateStr);
            
            $number = $request->number;

            $call_number = preg_replace('/[^0-9]/', '', $number);
            $user = User::create([
                'name' => $request->name,
                'role_id' => Role::USER_ID,
                'surname' => $request->surname,
                'number' => $call_number,
                'verify_code' => $randomNumber,
                'password' => Hash::make($request->password),
                'patronymic' => $request->patronymic,
                'city' => $request->city,
                'username' => $request->username,
                'date_of_birth' => $dateStr,
                'day' => $dateArray['day'],
                'mount' => $dateArray['month'],
            ]);
            if ($user) {

                try {
                    $client = new GreenSMS([
                        'user' => 'sadn',
                        'pass' => 'Dgdhh378qq',
                    ]);

                    $response = $client->sms->send([
                        'to' => $call_number,
                        'txt' => 'Ваш код потверждения' . $randomNumber
                    ]);
                } catch (Exception $e) {
                    User::where('id', $user->id)->delete();
                    return response()->json([
                        'status' => false,
                        'message' => 'Error in Green Smms',
                    ]);
                }

            }
            return response()->json([
                'success' => true,
                'message' => 'user successfully registered'
            ], 200);
        }
    }
}
