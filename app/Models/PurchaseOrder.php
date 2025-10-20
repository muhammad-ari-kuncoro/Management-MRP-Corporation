<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

  protected $table = 'tb_purchase_orders';

    protected $fillable = [
        'po_no',
        'po_date',
        'user_id',
        'supplier_id',
        'estimation_delivery_date',
        'note',
        'status',
        'currency',
        'currency_rate',
        'attachment',
        'approved_by',
        'approved_at',
        'transportation_fee',
        'journal_id'
    ];

    protected $casts = [
        'po_date' => 'date',
        'estimation_delivery_date' => 'date',
        'approved_at' => 'datetime',
        'currency_rate' => 'decimal:2',
        'transportation_fee' => 'decimal:2'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // Relasi ke Purchase Order Detail
    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id');
    }

    // Relasi ke User yang approve
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Calculate Subtotal
    public function getSubtotalAttribute()
    {
        return $this->details->sum('total');
    }

    // Calculate Total Discount
    public function getTotalDiscountAttribute()
    {
        return $this->details->sum('discount');
    }

    // Calculate PPN (11%)
    public function getPpnAttribute()
    {
        return $this->subtotal * 0.11;
    }

    // Calculate Grand Total
    public function getGrandTotalAttribute()
    {
        return $this->subtotal + $this->ppn + $this->transportation_fee;
    }

    // Status Badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => '<span class="badge bg-secondary">Draft</span>',
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'approved' => '<span class="badge bg-success">Approved</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            'waiting_goods' => '<span class="badge bg-info">Waiting Goods</span>',
            'completed' => '<span class="badge bg-primary">Completed</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}
