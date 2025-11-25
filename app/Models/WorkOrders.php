<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class WorkOrders extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tb_work_orders';
      protected $fillable = [
        'work_order_code',
        'product_id',
        'bom_id',
        'no_reference',
        'qty_ordered',
        'qty_completed',
        'delivery_date_product',
    ];
    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function billsOfMaterials()
    {
        return $this->belongsTo(BillsOfMaterial::class,'bom_id', 'id');
    }



}
