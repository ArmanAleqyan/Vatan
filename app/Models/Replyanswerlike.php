<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replyanswerlike extends Model
{
    use HasFactory;

    protected $table = "reply_answer_like";

    protected $guarded = [];

    public function replyanswer()
    {
        return $this->belongsTo(Replyanswer::class, 'reply_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
