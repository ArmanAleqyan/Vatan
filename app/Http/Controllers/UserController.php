<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function userOnlineStatus()
    {
        $users = User::all();

        foreach ($users as $user) {

            if (Cache::has('is_online' . $user->id)) {
                dd('is_online');
            } else {
                dd('offline');
            }
        }

    }
}
