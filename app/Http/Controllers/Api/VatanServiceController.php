<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VatanService;
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

                $client = new Client(['userName' => 't7733381896-api', 'password' => 'giJpZdtF' , 'apiUri' => Client::API_URI_TEST,'currency' => Currency::RUB]);

        $orderId     = time();
        $orderAmount = 1000;
        $returnUrl   = 'http://mycoolshop.local/payment-success';
        $params['currency'] = Currency::RUB;
        $params['failUrl']  = 'http://mycoolshop.local/payment-failure';
        $result = $client->registerOrder($orderId, $orderAmount, $returnUrl, $params);
        $paymentOrderId = $result['orderId'];
        $paymentFormUrl = $result['formUrl'];



        return response()->json([
           'status' => true,
           'data' => $paymentFormUrl
        ]);
    }




}
