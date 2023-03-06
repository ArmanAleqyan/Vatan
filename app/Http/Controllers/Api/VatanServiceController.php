<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VatanService;
use App\Models\RegisterPrice;
use App\Models\OrderTranzaction;
use Voronkovich\SberbankAcquiring\Client;
use Voronkovich\SberbankAcquiring\Currency;



class VatanServiceController extends Controller
{



    public function AllService(){
        $service = VatanService::OrderBy('id', 'Desc')->get();

        if(auth()->user()->register_payment == 0 || auth()->user()->register_payment == null){
            $active = RegisterPrice::all();
        }else{
            $active = null;
        }
      return response()->json([
         'status' => true,
         'data' => $service,
          'registerService' => $active
      ],200);
    }


    public function createOrder(Request $request){




        $client = new Client(['userName' =>  env('SberBankLogin'), 'password' =>  env('SberBankPassword'), 'apiUri' => Client::API_URI_TEST,'currency' => Currency::RUB]);
        $orderId     = time();
        $orderAmount = $request->price;
        $returnUrl   = $request->return;
//        route('successOrder');
        $params['currency'] = Currency::RUB;
        $params['failUrl']  =   'http://mycoolshop.local/payment-failure';

        $result = $client->registerOrder($orderId, $orderAmount, $returnUrl, $params);
        $paymentOrderId = $result['orderId'];

        $paymentFormUrl = $result['formUrl'];

        OrderTranzaction::create([
             'user_id' => auth()->user()->id,
             'order_id' =>  $paymentOrderId,
            'status' => 1
        ]);



        return response()->json([
           'status' => true,
           'data' => $paymentFormUrl
        ]);
    }




}
