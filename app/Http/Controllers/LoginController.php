<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     * path="api/login",
     * summary="User Login",
     * description="User Login here",
     * operationId="Login",
     * tags={"Login"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Login here",
     *    @OA\JsonContent(
     *               required={"email", "password","number"},
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="number", type="integer"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="User Login here",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $rules = array(
            'email' => 'email|max:255',
            'number' => 'max:255',
            'password' => 'required|min:6'

        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        if ($request->email) {
            if (Auth::attempt($request->all())) {
                $token = auth()->user()->createToken('API Token')->accessToken;

                User::where('id', auth()->user()->id)->update(['last_seen' => 'online']);

                return response(['user' => auth()->user(), 'token' => $token], 200);
            } else {
                return response(['error_message' => 'Incorrect Details. Please try again']);
            }
        } else {
            if (Auth::attempt($request->all())) {
                $token = auth()->user()->createToken('API Token')->accessToken;

                return response(['user' => auth()->user(), 'token' => $token], 200);
            } else {
                return response(['error_message' => 'Incorrect Details. Please try again']);
            }
        }
    }

    /**
     * @OA\Post(
     * path="api/verify",
     * summary="User Verify",
     * description="User Verify here",
     * operationId="Verify",
     * tags={"Verify"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Verify here",
     *    @OA\JsonContent(
     *               required={"verified_code"},
     *               @OA\Property(property="verified_code", type="int"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="User Verify here",
     *    @OA\JsonContent(
     *        )
     *     )
     * )
     */

    public function verify(Request $request)
    {

        $user_code = $request->verified_code;

        $users = User::where('verify_code', '=', $user_code)->get();

        if (!$users->isEmpty()) {

            $user_id = $users[0]->id;

            $updating = User::where('id', '=', $user_id)->update(['verify_code' => 1]);
            if ($updating) {
                return response()->json([
                    'success' => true,
                    'message' => 'user successfully verified'
                ], 200);
            }
            if (!$updating) {
                return response()->json([
                    'success' => false,
                    'message' => 'something was wrong'
                ], 422);
            }
        }
    }
}
