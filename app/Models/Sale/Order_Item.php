<?php

namespace App\Models\Sale;

use App\Models\Product\Menu_Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantity',
        'unit_price',
        'discount',
        'subtotal',
        'note',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(Menu_Item::class);
    }

    public function orderItemModifier()
    {
        return $this->hasMany(Order_Item_Modifier::class);
    }

    
}
