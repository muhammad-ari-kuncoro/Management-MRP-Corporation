<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillsOfMaterialsDetails extends Model
{
    use HasFactory;
    protected $table = 'tb_bills_of_materials_details';
    protected $fillable = [
        'bom_id',
        'item_id',
        'plan_qty',
        'notes',
    ];

     public function bom()
    {
        return $this->belongsTo(BillsOfMaterial::class, 'bom_id','id');
    }

     public function items()
    {
        return $this->belongsTo(Items::class, 'item_id', 'id');
    }
}
