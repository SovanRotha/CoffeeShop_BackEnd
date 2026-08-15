<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

   protected $fillable = [
    'name', 
    'email',
    'phone',
    'status'
   ];

   public function order()
   {
        return $this->hasMany(Order::class);
   }
}
