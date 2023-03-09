<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyVatanServiceTranzaction extends Model
{
    use HasFactory;
    protected $guarded =[];


    public function AddBalance()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
