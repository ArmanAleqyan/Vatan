<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatanService extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function VatanServiceDocumentList()
    {
        return $this->belongsto(VatanServiceDocumentList::class);
    }

    public function VatanServiceDocument()
    {
        return $this->hasMany(VatanServiceDocument::class);
    }
}
