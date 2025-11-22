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
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
}
