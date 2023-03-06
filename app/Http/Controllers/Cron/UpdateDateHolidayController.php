<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Holiday;

class UpdateDateHolidayController extends Controller
{

    public function UpdateDateHolidayController(){
        $get = Holiday::where('dateTime', NULL)->orwhere('dateTime', '<', Carbon::now())->get();
        foreach ($get as $item){
            $a = Carbon::parse($item->dateTime);
            $a->year = Carbon::now()->year +1;
            Holiday::where('id',$item->id )->update([
               'dateTime'  => $a
            ]);
        }
    }
}
