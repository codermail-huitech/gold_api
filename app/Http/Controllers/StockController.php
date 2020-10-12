<?php

namespace App\Http\Controllers;

use App\Model\OrderDetail;
use App\Model\Stock;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\DB;


class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderData = OrderDetail::select('order_details.id',DB::raw("concat(products.model_number,'-',products.product_name,'-',users.person_name) as order_name"),'order_details.order_master_id','order_details.price','order_details.approx_gold','order_details.quantity','order_details.product_id','products.model_number','products.product_name','order_masters.person_id','order_masters.order_number','users.person_name')
                     ->join('products','products.id','=','order_details.product_id')
                     ->join('order_masters','order_masters.id','=','order_details.order_master_id')
                     ->join('users','users.id','=','order_masters.person_id')
                     ->get();

        return response()->json(['success'=>1,'data'=>$orderData],200,[],JSON_NUMERIC_CHECK);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
