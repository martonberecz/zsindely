<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get orders
        $orders = Order::all();

        //return collection of orders as a resource
        return OrderResource::collection($orders);
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
       $payLoad = json_decode($request->getContent(), true);     
       
       
       foreach($payLoad as $pay){
        $order = new Order;
        $order->orderId = $pay["orderId"];
        $order->productId = $pay["productId"];
        $order->mennyiseg = $pay["mennyiseg"]; 
        $order->save();
       }       
       
       //print ($payLoad[0]["orderId"]);
       $order = Order::where('orderId', $payLoad[0]["orderId"])->first(); //

       if($order['orderId']>0){
        return new OrderResource($order);
       }      
                
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get orders
        $orders = Order::all()->where('orderId','=', $id);

        //return collection of orders as a resource
        return OrderResource::collection($orders);
    }
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orders = Order::all()->where('orderId','=', $id);

        for($i=0;$i<=sizeof($orders);$i++){
            $order = Order::findOrFail($id);
            $order->delete();
        }
        return OrderResource::collection($orders);        
    }
}
