<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function save($data)
    {
        $product = new $this->product;

        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->user_id = $data['user_id'];

        $product->save();

        return $product->fresh();
    }
    /*
    *
    *
    * @return Product $product
    */

    public function getAllProduct()
    {
        return $this->product->get();
    }
}