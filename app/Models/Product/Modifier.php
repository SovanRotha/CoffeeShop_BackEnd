<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'status',
    ];

    public function option()
    {
        return $this->hasMany(Modifier_Option::class);
    }

    public function menuItem()
    {
        return $this->belongsToMany(Menu_Item::class, 'menu_item_modifiers', 'modifier_id', 'menu_item_id')
            ->withPivot('is_required', 'sort_order');
    }
}
