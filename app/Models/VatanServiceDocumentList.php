<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatanServiceDocumentList extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function VatanServiceDocumentList()
    {
        return $this->Hasmany(VatanService::class);
    }
}
