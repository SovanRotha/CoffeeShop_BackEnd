<?php

namespace App\Models\Inventory;

use App\Models\Product\RecipeItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_category_id',
        'name',
        'base_unit',
        'current_stock',
        'cost_per_unit',
        'status',
    ];

    public function wasteRecord()
    {
        return $this->hasMany(Waste_Record::class);
    }

    public function stockLog()
    {
        return $this->hasMany(Stock_Log::class);
    }

    public function ingredientCategory()
    {
        return $this->belongsTo(Ingredient_Category::class);
    }

    public function recipeItem()
    {
        return $this->hasMany(RecipeItem::class);
    }

    public function stockAdjustment()
    {
        return $this->hasMany(StockAdjustment::class);
    }

}
