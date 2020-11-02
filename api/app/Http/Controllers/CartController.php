<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    /*public function __construct()
    {
        $this->middleware('auth:api');
    }*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_product = '2';
        $Product = Product::find($id_product);

        $rowId = 456; // generate a unique() row ID
        $userID = auth('api')->user()->id; // the user ID to bind the cart contents
        $cartID = 1;
        Cart::session($userID);

        // add the product to cart
        /*Cart::session($userID)->add(array(
            'id' => $cartID,
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => $Product,
        ));*/


        $items = Cart::session($userID)->getContent();
        /*foreach($items as $row) {

            echo $row->id; // row ID
            echo $row->name;
            echo $row->qty;
            echo $row->price;
            //return response()->json($row->name);
        }*/

        //Cart::session($userID)->remove($cartID);
        //dd($items);
        $total = Cart::getTotal();
        return  response()->json(array('items'=>$items,'total'=>$total));
        //return Cart::session($userID)->getContent();
        //return $total;
        //return view('cart.index');

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
        /*$request->validate([
            'user_id' => 'required',
        ]);

        $cart_user = Cart::where('user_id', Auth::id())->get()->count();

        if (Auth::check() && $cart_user > 0) {
            $input = $request->all();
            $input['user_id'] = $request->user_id;
            $cart = Cart::firstOrCreate($input);
        }

        return $cart;*/
        $id_product = '2';
        $Product = Product::find($id_product);

        $userID = auth('api')->user()->id; // the user ID to bind the cart contents
        $cartID = 2;

        Cart::session($userID)->add(array(
            'id' => $cartID,
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => 11,
            'attributes' => array(),
            'associatedModel' => $Product,
        ));

        return response()->json('deu bom');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        return $cart;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
