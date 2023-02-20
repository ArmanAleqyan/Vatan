<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Image;

class ImageDeletController extends Controller
{

    public function CronDeleteImageTable(){

        $image = Image::where('deleted_at', '!=', null)->where('deleted_at', '<',Carbon::now()->addMonths(-3))->get('image');


           foreach ($image as $im){
               $image_path = "uploads/".$im->image;
               if(file_exists($image_path)){
                   unlink($image_path);
               }
           }

        $image = Image::where('deleted_at', '!=', null)->where('deleted_at', '<',Carbon::now()->addMonths(-3))->delete();
//        dd($image);


    }
}
