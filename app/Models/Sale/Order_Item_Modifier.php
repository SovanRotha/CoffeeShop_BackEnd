<?php

namespace App\Models\Sale;

use App\Models\Product\Modifier;
use App\Models\Product\Modifier_Option;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Item_Modifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'modifier_id',
        'modifier_option_id',
        'quantity',
        'price_adjustment',
    ];

    public function orderItem()
    {
        return $this->belongsTo(Order_Item::class);
    }

    public function option()
    {
        return $this->belongsTo(Modifier_Option::class);
    }

    public function modifier()
    {
        return $this->belongsTo(Modifier::class);
    }
}
