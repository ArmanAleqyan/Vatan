<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VatanService;
use App\Models\RegisterPrice;
use App\Models\BuyVatanService;
use App\Models\BuyVatanServiceTranzaction;
use Voronkovich\SberbankAcquiring\Client;
use Voronkovich\SberbankAcquiring\Currency;
use Validator;

class BuyVatanServiceController extends Controller
{

    /**
     * @OA\Post(
     * path="api/add_balance",
     * summary="add_balance",
     * description="add_balance",
     * operationId="add_balance",
     * tags={"add_balance"},
     * @OA\RequestBody(
     *    required=true,
     *    description="add_balance",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="price", type="string", format="string", example="1000"),
     *          @OA\Property(property="return", type="string", format="string", example="1000"),
     *          @OA\Property(property="failUrl", type="string", format="string", example="1000"),
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


    public function add_balance(Request $request){
            $rules = array(
                'price' => 'required|between:1,1000000000',
                'return' => 'required',
                'failUrl' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $validator->errors();
            }
            $client = new Client(['userName' => env('SberBankLogin'), 'password' => env('SberBankPassword'), 'apiUri' => Client::API_URI_TEST, 'currency' => Currency::RUB]);
            $orderId = time();
            $orderAmount =   $request->price.'00';;
            $returnUrl = $request->return;
            $params['currency'] = Currency::RUB;
            $params['failUrl'] = $request->failUrl;
            $result = $client->registerOrder($orderId, $orderAmount, $returnUrl, $params);
            $paymentOrderId = $result['orderId'];
            $paymentFormUrl = $result['formUrl'];

            BuyVatanServiceTranzaction::create([
                'user_id' => auth()->user()->id,
                'price' => $request->price,
                'tranzaction_id' => $paymentOrderId
            ]);
            return response()->json([
                'status' => true,
                'url' => $paymentFormUrl
            ], 200);
    }


    /**
     * @OA\Post(
     * path="api/suc_add_balance",
     * summary="suc_add_balance",
     * description="suc_add_balance",
     * operationId="suc_add_balance",
     * tags={"add_balance"},
     * @OA\RequestBody(
     *    required=true,
     *    description="add_balance",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="order_id", type="string", format="string", example="567a1bd0-0d95-7995-8c0c-c48c28ea21ef"),
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

    public function suc_add_balance(Request $request){
        $rules = array(
            'order_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $get = BuyVatanServiceTranzaction::where('tranzaction_id', $request->order_id)->where('status', '!=',2)->first();
        if($get == null){
            return response()->json([
               'status' => false,
               'message' => 'wrong order_id'
            ],422);
        }
        User::where('id', auth()->user()->id)->update([
           'balance' => auth()->user()->balance + $get->price
        ]);
        BuyVatanServiceTranzaction::where('tranzaction_id', $request->order_id)->update([
           'status' => 2
        ]);
        return response()->json([
           'status' => true,
           'message' =>  'balance added'
        ],200);
    }


    /**
     * @OA\Post(
     * path="api/err_add_balance",
     * summary="err_add_balance",
     * description="err_add_balance",
     * operationId="err_add_balance",
     * tags={"add_balance"},
     * @OA\RequestBody(
     *    required=true,
     *    description="add_balance",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="order_id", type="string", format="string", example="567a1bd0-0d95-7995-8c0c-c48c28ea21ef"),
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

    public function err_add_balance(Request $request){
        $rules = array(
            'order_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $get = BuyVatanServiceTranzaction::where('tranzaction_id', $request->order_id)->first();
        if($get == null){
            return response()->json([
                'status' => false,
                'message' => 'wrong order_id'
            ],422);
        }
        BuyVatanServiceTranzaction::where('tranzaction_id', $request->order_id)->delete();


        return response()->json([
           'status' => true,
           'message' =>  'add balance  failed'
        ],400);



    }


    /**
     * @OA\Post(
     * path="api/buy_vatan_service_tranzaction",
     * summary="buy_vatan_service_tranzaction",
     * description="buy_vatan_service_tranzaction",
     * operationId="buy_vatan_service_tranzaction",
     * tags={"orders"},
     * @OA\RequestBody(
     *    required=true,
     *    description="buy_vatan_service_tranzaction",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="service_id", type="string", format="string", example="1"),
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


    public function buy_vatan_service_tranzaction(Request $request)
    {
        $getService = VatanService::where('id', $request->service_id)->first();


        if ($getService == null) {
            return response()->json([
                'status' => false,
                'message' => 'wrong service id'
            ], 422);
        }

        if ($getService->price > auth()->user()->balance) {
//            $client = new Client(['userName' => env('SberBankLogin'), 'password' => env('SberBankPassword'), 'apiUri' => Client::API_URI_TEST, 'currency' => Currency::RUB]);
//            $orderId = time();
//            $orderAmount =   $getService->price.'00';;
////                $getService->price.'00';
//            $returnUrl = $request->return;
//            $params['currency'] = Currency::RUB;
//            $params['failUrl'] = $request->failUrl;
//            $result = $client->registerOrder($orderId, $orderAmount, $returnUrl, $params);
//            $paymentOrderId = $result['orderId'];
//            $paymentFormUrl = $result['formUrl'];
//            BuyVatanServiceTranzaction::create([
//                'user_id' => auth()->user()->id,
//                'service_id' => $request->service_id,
//                'tranzaction_id' => $paymentOrderId
//            ]);

            return response()->json([
                'status' => true,
                'message' => 'you dont have price in balance',
//                'url' => $paymentFormUrl
            ], 200);

        }elseif($getService != null){
            User::where('id', auth()->user()->id)->update([
               'balance' => auth()->user()->balance -  $getService->price
            ]);
            BuyVatanService::create([
                'user_id' => auth()->user()->id,
                'service_id' => $request->service_id,
                'title' => 'Покупка услуги ('.$getService->title.')',
                'price' => $getService->price
            ]);
            return response()->json([
               'status' => true,
               'message' => 'User buy This Service'
            ],200);
        }
    }


    /**
     * @OA\Post(
     * path="api/buy_vatan_service_register",
     * summary="buy_vatan_service_register",
     * description="buy_vatan_service_register",
     * operationId="buy_vatan_service_register",
     * tags={"orders"},
     * @OA\RequestBody(
     *    required=true,
     *    description="buy_vatan_service_register",
     *    @OA\JsonContent(
     *       required={"required"},
     *          @OA\Property(property="register_id", type="string", format="string", example="1"),
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

    public function buy_vatan_service_register(Request $request)
    {
        $getService = RegisterPrice::where('id', $request->register_id)->first();


        if ($getService == null) {
            return response()->json([
                'status' => false,
                'message' => 'wrong register id'
            ], 422);
        }

        if ($getService->price > auth()->user()->balance) {
            return response()->json([
                'status' => true,
                'message' => 'you dont have price in balance',
            ], 200);
        }elseif($getService != null){
            User::where('id', auth()->user()->id)->update([
               'balance' => auth()->user()->balance -  $getService->price,
                'register_payment' => 1
            ]);
            BuyVatanService::create([
                'user_id' => auth()->user()->id,
                'title' => 'Покупка услуги ('.$getService->title.')',
                'price' => $getService->price
            ]);
            return response()->json([
               'status' => true,
               'message' => 'User buy This Service'
            ],200);
        }
    }

    /**
     * @OA\Get(
     * path="api/get_history_buy",
     * summary="get_history_buy",
     * description="get_history_buy",
     * operationId="get_history_buy",
     * tags={"orders"},
     * @OA\RequestBody(
     *    required=true,
     *    description="buy_vatan_servic
     * e_register",
     *    @OA\JsonContent(
     *       required={"required"},
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



    public function get_history_buy(){
            $get = BuyVatanService::where('user_id', auth()->user()->id)->orderBy('id','desc')->simplepaginate(10);

            return response()->json([
               'status' => true,
               'data' => $get,
            ],200);
    }
}
