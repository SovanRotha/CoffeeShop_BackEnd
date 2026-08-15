<?php

namespace App\Models\Inventory;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'type',
        'quantity',
        'reference_type',
        'reference_id',
        'note',
        'user_id',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
