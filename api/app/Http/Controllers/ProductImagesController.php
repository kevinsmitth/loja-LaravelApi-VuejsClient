<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class ProductImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductImage::all();
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

       
  
        
        
        $request->validate([
            'filename' => 'required',
            'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_id' => 'required'
        ]);
        
        $productImage = $request->all();
        $productImage['product_id'] = $request->product_id;

        if($request->hasFile('filename') && $request->filename->isValid()){

            $productImage['filename'] = $request->file('filename');
            $image = $productImage['filename'];
            $filename  = hash('sha1', $image) . '.' . $image->getClientOriginalExtension();
     
            $imageResize = Image::make( $image->getRealPath() )->fit(1920, 1080)->save(
                storage_path('app/public/images/'.$filename)
            );
            $imagePath = ('images/'.$filename);
        
            $productImage['filename'] = $imagePath;
            
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
            return $Image;

            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImages
     * @return \Illuminate\Http\Response
     */
    public function show(ProductImage $productImage)
    {
        return $productImage;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductImage $productImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductImage $productImage)
    {
        File::delete(storage_path('app/public/'.$productImage->filename));
        $productImage->delete();
        if ($productImage->count() <= 0) {
            $productImage['filename'] = 'images/imagem-padrao.png';
            $productImage['status'] = 'destaque';
            $productImage['product_id'] = $productImage;
            ProductImage::create($productImage);
        }
        return response()->json(['success' => true]);
    }
}
