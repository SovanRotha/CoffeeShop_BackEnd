<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu_Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image',
        'price',
        'status',
        'is_available',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function modifiers()
    {
        return $this->belongsToMany(Modifier::class, 'menu_item_modifiers', 'menu_item_id', 'modifier_id')
            ->withPivot('is_required', 'sort_order');
    }

    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }
}
