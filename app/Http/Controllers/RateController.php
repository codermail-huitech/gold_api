<?php

namespace App\Http\Controllers;

use App\Model\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function getRates()
    {
        $data = Rate::select('id','price_code_id','price','p_loss','customer_category_id')->get();
        return response()->json(['success'=>1,'data'=>$data], 200);
    }

    public function newRate(Request $request)
    {
        $input=($request->json()->all());
        $newData=(object)($input['rateData']);
        $rate = new Rate();
        $rate->price_code_id = $newData->price_code_id;
        $rate->p_loss = $newData->p_loss;
        $rate->price = $newData->price;
        $rate->customer_category_id = $newData->customer_category_id;
        $rate-> save();
        return response()->json(['success'=>1,'data'=>$rate], 200);
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
     * @param  \App\Model\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show(Rate $rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function edit(Rate $rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rate $rate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate)
    {
        //
    }
}
