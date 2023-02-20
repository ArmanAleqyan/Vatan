<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function PostLike()
    {
        return $this->hasMany(Postlikes::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class)->where('deleted_at', NULL);
    }


    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentLike()
    {
        return $this->hasMany(Commentslike::class);
    }


    public function PostLikeAuthUser()
    {
        return $this->hasmany(Postlikes::class)->where('user_id', auth()->user()->id);
    }


















    public function postlikes()
    {
        return $this->hasMany(Postlikes::class);
    }



    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
