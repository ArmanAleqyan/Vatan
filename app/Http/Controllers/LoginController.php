<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginUsesRequest;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(LoginUsesRequest $request)
    {
        $data = $request->validated();
    }
}
