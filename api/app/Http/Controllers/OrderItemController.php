<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentType;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_user = Order::where('user_id', Auth::user()->id)->pluck('id');
        $order_user_id = Order::with('user', 'address', 'payment_type')->where('user_id', Auth::user()->id)->get();
        $order_items = OrderItem::with('order', 'product')->where('order_id', $order_user)->get();
        
        return response()->json(array('order_user_id' => $order_user_id, 'order_items' => $order_items));
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
        $order_id = Order::select('id')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->value('id');
        $id_product = CartProduct::select('product_id')->where('user_id', Auth::user()->id)->get('id');
        $order_product = Product::select('id')->find($id_product)->pluck('id');
        $order_quantity = CartProduct::select('quantity')->where('user_id', Auth::user()->id)->pluck('quantity');
        $order_value = CartProduct::select('value')->where('user_id', Auth::user()->id)->pluck('value');

        $cart_products = CartProduct::where('user_id', Auth::user()->id)->count('id');
            
        $order = [];

        for($i = 0; $i < $cart_products; $i++){
            $order[] = [
                'order_id' => $order_id,
                'product_id' => $order_product[$i],
                'quantity' => $order_quantity[$i],
                'value' => $order_value[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        
        }
        OrderItem::insert($order);
        return $order;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show(Order $orderItem)
    {
        $order = Order::with('user', 'address', 'payment_type')->where('id', $orderItem->id)->get();
        $order_items = OrderItem::with('product', 'order')->where('order_id', $orderItem->id)->get();
        return response()->json(array('order' => $order, 'order_items' => $order_items));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
