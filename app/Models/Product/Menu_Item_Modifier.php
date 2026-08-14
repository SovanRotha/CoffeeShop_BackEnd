<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu_Item_Modifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'modifier_id',
        'is_required',
        'sort_order',
    ];

    
}
