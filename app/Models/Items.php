<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $table = 'tb_items';
    protected $guarded = ['id'];
    public function branchCompany()
    {
        return $this->belongsTo(BranchCompany::class);
    }
}
