<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'name',
        'description',
        'status',
    ];

    public function menuItem()
    {
        return $this->belongsTo(Menu_Item::class);
    }

    public function recipeItem()
    {
        return $this->hasMany(RecipeItem::class);
    }
}
