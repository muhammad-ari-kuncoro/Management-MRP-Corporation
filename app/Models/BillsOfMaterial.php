<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillsOfMaterial extends Model
{
    use HasFactory;
    protected $table = 'tb_bills_of_materials';

    protected $fillable = [
        'user_id',
        'date_bom',
        'code_bom',
        'revision',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
