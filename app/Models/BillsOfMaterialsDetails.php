<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillsOfMaterialsDetails extends Model
{
    use HasFactory;
    protected $table = 'tb_bills_of_materials_details';

     public function bom()
    {
        return $this->belongsTo(BillsOfMaterial::class, 'bom_id');
    }

     public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }
}
