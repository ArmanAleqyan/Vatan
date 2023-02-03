<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\Chat;
use App\Models\Role;
use App\Models\CallCount;
use Illuminate\Support\Facades\Hash;
use GreenSMS\GreenSMS;
use Illuminate\Support\Facades\Mail;
use Exception;
use Validator;
use   App\Events\ChatNotification;



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

        $randomNumber = random_int(100000, 999999);
        if ($request->email) {
            $dateStr = $request->date_of_birth;
            $dateArray = date_parse_from_format('Y-m-d', $dateStr);
            $getuser = User::where('email', $request->email)->where('username', $request->username)->where('verify_code', '!=', 1)->first();
            if($getuser != null){

                $Carbon = Carbon::now();
                $Carbon2 = Carbon::now();
                $callCount = CallCount::where('email', $request->email)->where('type', 'registration')
                    ->whereBetween('created_at' , [$Carbon->addMinutes(-10), $Carbon2])
                    ->count();

//                if($callCount <= 3){
//                    CallCount::create([
//                        'email' => $request->email,
//                        'type' => 'registration'
//                    ]);
//                }else{
//                    return response()->json([
//                        'status' => false,
//                        'message' => 'your email is blocked 10 minutes'
//                    ]);
//                }


             $user =   User::where('email', $request->email)->where('username', $request->username)->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
//                    'email' => $request->email,
                    'role_id' => Role::USER_ID,
                    'verify_code' => $randomNumber,
                    'password' => Hash::make($request->password),
                    'patronymic' => $request->patronymic,
                    'city' => $request->city,
//                    'username' => $request->username,
//                    'date_of_birth' => $dateStr,
                    'day' => $dateArray['day'],
                    'month' => $dateArray['month'],
                ]);




                    $details = [
                        'email' => $request->name,
                        'verification_at' => $randomNumber,
                    ];
                Mail::to($request->email)->send(new SendMail($details));

                return response()->json([
                    'success' => true,
                    'message' => 'user successfully registered',
                    'verify code' => $randomNumber
                ], 200);
            }


            $rules = array(
                'email' => 'required|max:64|unique:users|email',
                'name' => 'required|max:64',
                'surname' => 'required|max:64',
                'password' => 'required|min:6|max:64',
                'password_confirmation' => 'required_with:password|same:password|min:6|max:64',
                'patronymic' => 'required|max:64',
                'city' => 'required',
                'username' => 'unique:users|required',
                'date_of_birth' => 'required',

            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $validator->errors();
            }

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
                'month' => $dateArray['month'],
            ]);
            if ($user) {
                $details = [
                    'email' => $user->name,
                    'verification_at' => $randomNumber,
                ];
            }
            Mail::to($user->email)->send(new SendMail($details));

            $getCount = 1;

            $room_id = time();
            $chat = Chat::create([
                'sender_id' => $user->id,
                'receiver_id' => 1,
                'messages' => $user->name.' '. ' '.$user->surname.' '. ' '.'Тепер в Vatan.su',
                'notification' => 0,
                'room_id' => $room_id,
                'created_at' => Carbon::now()
            ]);
            $lattestMessage = Chat::where('sender_id', $user->id)->where('receiver_id',1)->latest()->first();

            $lattestMessage['notification'] = $lattestMessage->created_at->diffForHumans();

            $receiverUser = User::where('id', 1)->get();

            event(new ChatNotification($chat, $receiverUser, $user,$getCount,$lattestMessage->created_at->diffForHumans()));
            return response()->json([
                'success' => true,
                'message' => 'Register Successfully',
                'verify code' => $randomNumber
            ], 200);
        }
        else {
            $dateStr = $request->date_of_birth;
            $dateArray = date_parse_from_format('Y-m-d', $dateStr);
            $number = $request->number;
            $call_number = preg_replace('/[^0-9]/', '', $number);
            $getuser = User::where('number' ,$call_number)->where('username', $request->username)->where('verify_code', '!=', 1)->first();
            if($getuser != null){

                $Carbon = Carbon::now();
                $Carbon2 = Carbon::now();
                $callCount = CallCount::where('number', $call_number)->where('type', 'registration')
                    ->whereBetween('created_at' , [$Carbon->addMinutes(-10), $Carbon2])
                    ->count();
//
//                if($callCount <= 3){
//                    CallCount::create([
//                        'number' => $call_number,
//                        'type' => 'registration'
//                    ]);
//                }else{
//                    return response()->json([
//                        'status' => false,
//                        'message' => 'your number is blocked 10 minutes'
//                    ]);
//                }

                $user =   User::where('number', $call_number)->where('username', $request->username)->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
//                    'number' => $call_number,
                    'role_id' => Role::USER_ID,
                    'verify_code' => $randomNumber,
                    'password' => Hash::make($request->password),
                    'patronymic' => $request->patronymic,
                    'city' => $request->city,
//                    'username' => $request->username,
                    'date_of_birth' => $dateStr,
                    'day' => $dateArray['day'],
                    'month' => $dateArray['month'],
                ]);
                try {
                    $client = new GreenSMS([
                        'user' => 'sadn',
                        'pass' => 'Dgdhh378qq',
                    ]);

                    $response = $client->sms->send([
                        'from' =>  'vatan',
                        'to' => $call_number,
                        'txt' => 'Ваш код потверждения' .' '. $randomNumber
                    ]);

                } catch (Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Error in Green Smms',
                        'green_error' => $e
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'user successfully registered',
                    'verify code' => $randomNumber
                ], 200);
            }

            $number = $request->number;
            $call_number = preg_replace('/[^0-9]/', '', $number);

            $request['number'] = $call_number;

            $rules = array(
                'number' => 'unique:users|required|max:64',
                'name' => 'required|max:64',
                'surname' => 'required|max:64',
//                'password' => 'required|min:6|max:64|confirmed',
//                'password_confirmation' => 'required|min:6|max:64',
                'password' => 'required|min:6|max:64',
                'password_confirmation' => 'required_with:password|same:password|min:6|max:64',
                'patronymic' => 'required|max:64',
                'city' => 'required',
                'username' => 'unique:users|required',
                'date_of_birth' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $validator->errors();
            }


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
                'month' => $dateArray['month'],
            ]);
            try {
                $client = new GreenSMS([
                    'user' => 'sadn',
                    'pass' => 'Dgdhh378qq',
                ]);
                $response = $client->sms->send([
                    'from' =>  'vatan',
                    'to' => $call_number,
                    'txt' => 'Ваш код потверждения' .' '. $randomNumber
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error in Green Smms',
                ]);
            }
            if ($user) {

                $getCount = 1;
                $room_id = time();
                $chat = Chat::create([
                    'sender_id' => $user->id,
                    'receiver_id' => 1,
                    'messages' => $user->name.' '. ' '.$user->surname.' '. ' '.'Тепер в Vatan.su',
                    'notification' => 0,
                    'room_id' => $room_id,
                    'created_at' => Carbon::now()
                ]);
                $lattestMessage = Chat::where('sender_id', $user->id)->where('receiver_id',1)->latest()->first();

                $lattestMessage['notification'] = $lattestMessage->created_at->diffForHumans();

                $receiverUser = User::where('id', 1)->get();

                event(new ChatNotification($chat, $receiverUser, $user,$getCount,$lattestMessage->created_at->diffForHumans()));

                return response()->json([
                    'success' => true,
                    'message' => 'user successfully registered',
                    'verify code' => $randomNumber
                ], 200);
            }
            }
        }


        public function SendCodeTwo(Request $request){
            $randomNumber = random_int(100000, 999999);
        if(isset($request->number)){
            $number = $request->number;
            $call_number = preg_replace('/[^0-9]/', '', $number);
            $Carbon = Carbon::now();
            $Carbon2 = Carbon::now();
            $callCount = CallCount::where('number', $call_number)->where('type', 'registr')
                ->whereBetween('created_at' , [$Carbon->addMinutes(-10), $Carbon2])
                ->count();
//            if($callCount <= 3){
//                CallCount::create([
//                   'number' => $call_number,
//                   'type' => 'registr'
//                ]);
//            }else{
//                return response()->json([
//                   'status' => false,
//                   'message' => 'your number is blocked 10 minutes'
//                ]);
//            }
            try {
                $client = new GreenSMS([
                    'user' => 'sadn',
                    'pass' => 'Dgdhh378qq',
                ]);
                $response = $client->sms->send([
                   'from' => 'vatan',
                    'to' => $call_number,
                    'txt' => 'Ваш код потверждения' .' '. $randomNumber
                ]);

                $call_number = preg_replace('/[^0-9]/', '', $request->number);
                User::where('number', $call_number)->where('verify_code', '!=', 1)->update([
                   'verify_code' =>  $randomNumber
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error in Green Smms',
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'code send your number',
                'code' => $randomNumber,
            ], 200);
        }
        elseif (isset($request->email)){

            $Carbon = Carbon::now();
            $Carbon2 = Carbon::now();
            $callCount = CallCount::where('email', $request->email)->where('type', 'registr')
                ->whereBetween('created_at' , [$Carbon->addMinutes(-10), $Carbon2])
                ->count();
//
//            if($callCount < 3){
//                CallCount::create([
//                    'email' => $request->email,
//                    'type' => 'registr'
//                ]);
//            }else{
//                return response()->json([
//                    'status' => false,
//                    'message' => 'your email is blocked 10 minutes'
//                ]);
//            }



            User::where('email', $request->email)->where('verify_code', '!=', 1)->update([
                'verify_code' =>  $randomNumber
            ]);

            $getUser =   User::where('email', $request->email)->first();
            if($getUser != null){
                $email =  $getUser->name;
            }else{
                $email = $request->email;
            }

            $details = [
                'email' => $email,
                'verification_at' => $randomNumber,
            ];
            Mail::to($request->email)->send(new SendMail($details));

            return response()->json([
                'status' => true,
                'message' => 'code send your email',
                'code' => $randomNumber,
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' =>  'Incorect Parametrs'
            ],422);
        }
        }
}
