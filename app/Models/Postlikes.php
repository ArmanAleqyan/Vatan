<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postlikes extends Model
{
    use HasFactory;

    protected $table = 'posts_likes';

    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
