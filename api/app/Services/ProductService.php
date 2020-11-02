<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ProductService
{   

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function saveProductData($data)
    {
        $validator = Validator::make($data,[
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'user_id' => 'required',

        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->productRepository->save($data);

        return $result;
    }

    public function getAll()
    {
        return $this->productRepository->getAllProduct();
    }
}