<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    /*public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('image')->get();

        return response()->json(array('products' => $products));

        /*$result = ['status' => 200];

        try {
            $result['data'] = $this->productService->getAll();
        } catch (\Throwable $th) {
            $result = [
                'status' => 500,
                'error' => $th->getMessage() 
            ];
        }

        return response()->json($result, $result['status']);*/

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        /*$data = $request->only([
            'name',
            'description',
            'price',
            'user_id',
            'filename',
            'product_id',
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->productService->saveProductData($data);


        } catch (\Throwable $th) {
            $result = [
                'status' => 500,
                'error' => $th->getMessage() 
            ];
        }

        return response()->json($result, $result['status']);*/
        
        
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'user_id' => 'required'
        ]);

        $product = Product::create($request->all());

        $productImage = $request->all();
        $productId = Product::latest('id')->select('id')->first()->id;
        $productImage['product_id'] = $productId;

            if($request->hasFile('filename') && $request->filename->isValid()){
                $imagePath = $request->file('filename')->store('images', 'public');
                
                $productImage['filename'] = $imagePath;
                
            }
            else {                
                $productImage['filename'] = 'images/imagem-padrao.png';
            }
                $productImage_exists = ProductImage::where('product_id', $productImage['product_id'])->first();
                if ($productImage_exists) {
                    $productImage['status'] = 'normal';
                    $Image = ProductImage::create($productImage);
                }

                else{
                $productImage['status'] = 'destaque';
                $Image = ProductImage::create($productImage);
                }

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $productImages = ProductImage::where('product_id', $product->id)->orderBy('status')->get();

        return response()->json(array('product'=> $product, 'productImages'=> $productImages));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'user_id' => 'required'
        ]);

        $params = $request->all();
        $product->update($params);

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['success' => true]);
    }
}
