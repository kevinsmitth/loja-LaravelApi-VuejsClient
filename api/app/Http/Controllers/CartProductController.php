<?php

namespace App\Http\Controllers;

//use App\Models\Cart;

use App\Models\Address;
use App\Models\CartProduct;
use App\Models\CartStorage;
use App\Models\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $cart = CartProduct::with('produto')->where('user_id', Auth::id())->get();
        
        $total = CartProduct::select('value')->where('user_id', Auth::id())->sum('value');

        $user = Auth::user();

        $user_address = Address::where('user_id', $user->id)->first();
        
        return response()->json(array('cart'=>$cart,'total'=>$total, 'userAddress'=>$user_address));
        /*$cartValue = CartProduct::select('value')->where('user_id', Auth::id())->sum('value');

        foreach ($cartProduct as $value) {
           
            echo "<p>
            {$value->produto->name}
            {$value->produto->description}
            {$value->quantity}
            {$value->produto->price}
            </p>";
            
        }*/

        
        //echo $total;
        //echo "{$cart->name}";
        //return $cart->name;
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
    public function store(Request $request, Product $product, CartProduct $cartProduct)
    {


        $id_product = $request->product_id;
        $product = Product::find($id_product);
        $userId = auth()->user()->id;

        $request->validate([
            //'user_id' => 'required',
            'quantity' => 'required',
            'product_id' => 'required',
            //'value' => 'required',
            //'associatedModel' => $product,
        ]);

        /*$hasProduct_cart = CartProduct::where('product_id', Auth::id())->get()->count();

        if ($product == null || $request->product_id != $product->id) {
            return response()->json(['Produto inexistente ou esgotado' => false], 401);
        }

        if ($hasProduct_cart > 0) {
            $my_carts = CartProduct::get('product_id');
            foreach ($my_carts as $my_cart) {
            }
                if ($request->product_id == $my_cart->product_id) {
                
                    return response()->json(['Produto ja se encontra no carrinho' => false], 401);
                }
        }*/

        $input = $request->all();
        $input['user_id'] = $userId;
        $input['value'] = $product->price *= $input['quantity'];
        $cartProduct = CartProduct::create($input);


        return $cartProduct; 


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CartProduct $cartProduct)
    {
        //return $cartProduct;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(CartProduct $cartProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartProduct $cartProduct)
    {
        $params = $request->all();
        $product = Product::find($request->product_id);
        $params['value'] = $product->price *= $params['quantity'];
        $cartProduct->update($params);

        return $cartProduct;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartProduct $cartProduct)
    {
        $cartProduct->delete();
        return response()->json(['success' => true]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
