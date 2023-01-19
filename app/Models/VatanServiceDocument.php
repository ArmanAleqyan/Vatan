<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatanServiceDocument extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function VatanServiceDocument()
    {
        return $this->belongsto(VatanServiceDocument::class , 'service_id');
    }
}
