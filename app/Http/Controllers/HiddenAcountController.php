<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HiddenAcountController extends Controller
{
    public function hiddenAccount(Request $request)
    {
        $password = $request->password;

        $hash_check = Hash::check($request->password, $password);
        dd($hash_check);
    }
}
