<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BranchCompany extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_branch_company_items';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
}
