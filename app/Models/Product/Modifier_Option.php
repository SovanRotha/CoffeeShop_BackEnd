<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modifier_Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'modifier_id',
        'name',
        'price',
        'status',
    ];

    public function modifier()
    {
        return $this->belongsTo(Modifier::class);
    }
}
