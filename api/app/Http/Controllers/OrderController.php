<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $orders = Order::with('user', 'address', 'payment_type')->where('user_id', Auth::user()->id)->get();
        return response()->json($orders);
 

        

        //return Order::all();
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
            'payment_type_id' => 'required'
        ]);
        
        $user_address = Address::where('user_id', Auth::user()->id)->select('id')->first();
        
        $order = $request->all();
        $order['user_id'] = Auth::user()->id;
        $order['address_id'] = $user_address->id;
        $order['payment_type_id'] = $request->payment_type_id;
        $order['total'] = CartProduct::select('value')->where('user_id', Auth::id())->sum('value');
        $order['status'] = 'Pendente';
        $order_do = Order::create($order);
//

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

        CartProduct::where('user_id', Auth::user()->id)->delete();

        return $order_do;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $order;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $params = $request->all();
        $order->update($params);

        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['success' => true]);
    }
}
