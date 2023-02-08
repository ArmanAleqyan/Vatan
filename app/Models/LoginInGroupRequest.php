<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginInGroupRequest extends Model
{
    use HasFactory;
    protected  $guarded =[];

    public function LoginInGroupRequest()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

}
