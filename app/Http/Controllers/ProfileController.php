<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Changenumber;
use GreenSMS\GreenSMS;
use Validator;



class ProfileController extends Controller
{
    /**
     * @OA\Post(
     * path="api/change-number",
     * summary="User Send Number for change",
     * description="User Send Number for change",
     * operationId="User Send Number for change",
     * tags={"Change Number"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Send Number for change",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="number", type="integer", format="number", example="1234567
     * "),
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

    public function addNumber(Request $request)
    {

        $call_number = preg_replace('/[^0-9]/', '', $request->number);

        $randomNumber = random_int(100000, 999999);

        $request['number'] = $call_number;

        $rules = array(
            'number' => 'required|max:64|unique:users',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        try {
            $client = new GreenSMS([
                'user' => 'sadn',
                'pass' => 'Dgdhh378qq',
            ]);
            Changenumber::where('user_id', auth()->user()->id)->delete();
            $credentails = [
                'number' => $call_number,
                'user_id' => auth()->user()->id,
                'random_int' => $randomNumber
            ];

            $CreateNumber = Changenumber::create($credentails);


            $response = $client->sms->send([
                'from' => 'vatan',
                'to' => $call_number,
                'txt' => 'Ваш код потверждения ' .' '. $randomNumber
            ]);
            return response()->json([
                'success' => true,
                'message' => 'number change code sent to your phone',
                'verify'=>$randomNumber
            ], 200);
        }catch (\Exception $e){
            return response()->json([
               'status' => false,
               'message' => 'Green Error'
            ]);
        }



    }

    /**
     * @OA\Post(
     * path="api/update-number",
     * summary="User Send code for change",
     * description="User Send code for change",
     * operationId="User Send code ",
     * tags={"Change Number"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Send code for change",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="random_int", type="int", format="int", example="123456"),
     *          @OA\Property(property="user_id", type="int", format="int", example="8"),
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


    public function UpdateNumber(Request $request)
    {
        $code = $request->random_int;
        $user_id = $request->user_id;

        $user_number = Changenumber::where('random_int', $code)->where('user_id', $user_id)->get();

        if (!$user_number->isEmpty()) {
            $number = User::where('id', $user_id)->update([
                'number' => $user_number[0]->number
            ]);
            $delete = Changenumber::where(['user_id' => $user_id])->delete();

            if ($delete) {
                return response()->json([
                    'success' => true,
                    'message' => 'your phone number successfully changed'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something was wrong'
            ]);
        }
    }
}
