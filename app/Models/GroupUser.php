<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function UserGroupReal()
    {
        return $this->belongsto(GroupUser::class, 'user_id');
    }

    public function User()
    {
        return $this->belongsto(User::class, 'user_id');
    }

    public function Group()
    {
        return $this->belongsto(Group::class, 'group_id');
    }
}
