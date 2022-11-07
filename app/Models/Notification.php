<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $guarded = [];

    public function sendernotification()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receivernotification()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
