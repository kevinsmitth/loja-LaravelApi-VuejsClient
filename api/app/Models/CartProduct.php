<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $table = 'cart_products';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'value',
    ];

        public function produto()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
