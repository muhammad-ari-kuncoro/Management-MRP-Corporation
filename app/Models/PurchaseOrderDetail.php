<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrderDetail extends Model
{
    protected $table = 'tb_purchase_orders_details';

    protected $fillable = [
        'purchase_order_id',
        'items_id',
        'qty',
        'discount',
        'total'
    ];

    protected $casts = [
        'qty' => 'integer',
        'discount' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    // Relasi ke Purchase Order
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    // Relasi ke Items
    public function items()
    {
        return $this->belongsTo(Items::class, 'items_id');
    }

    // Accessor untuk mendapatkan harga item
    public function getPriceAttribute()
    {
        return $this->items ? $this->items->price_item : 0;
    }

    // Accessor untuk mendapatkan subtotal sebelum diskon
    public function getSubtotalBeforeDiscountAttribute()
    {
        return $this->price * $this->qty;
    }

    // Accessor untuk format rupiah
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDiscountAttribute()
    {
        return 'Rp ' . number_format($this->discount, 0, ',', '.');
    }

    // Method untuk recalculate total
    public function recalculateTotal()
    {
        $subtotal = $this->price * $this->qty;
        $this->total = $subtotal - $this->discount;
        $this->save();

        return $this->total;
    }
}
