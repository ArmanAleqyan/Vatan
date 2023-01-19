<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

//        if (auth()->user()->register_payment == 0 || auth()->user()->register_payment == null) {
//            return response()->json([
//             'status' => false,
//               'message' =>  'Mane jan es user@ registraciyi poxer@ chi tvel )))'
//            ], 422);
//        }
        return $next($request);
    }
}
