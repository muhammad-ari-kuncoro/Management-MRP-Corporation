<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'tb_suppliers';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function branchCompany()
    {
        return $this->belongsTo(BranchCompany::class, 'branch_company_id', 'id');
    }


}
