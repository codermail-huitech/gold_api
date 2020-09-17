<?php

namespace App\Http\Controllers;

use App\Model\CustomerCategory;
use App\Model\PriceCode;
use App\Model\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function getRates()
    {
        $data = Rate::select('rates.id','price_codes.price_code_name','customer_categories.customer_category_name','rates.price_code_id','rates.price','rates.p_loss','rates.customer_category_id')
            ->join('price_codes', 'price_codes.id', '=', 'rates.price_code_id')
            ->join('customer_categories', 'customer_categories.id', '=', 'rates.customer_category_id')
            ->get();
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

        $rate->customer_category_name = (CustomerCategory::select('customer_category_name')
            ->where('id','=',$rate->customer_category_id)
            ->get())[0] -> customer_category_name;

        $rate->price_code_name = (PriceCode::select('price_code_name')
            ->where('id','=',$rate->price_code_id)
            ->get())[0] -> price_code_name;

        return response()->json(['success'=>1,'data'=>$rate], 200);
    }

    public function deleteRate($id)
    {
        $rate = new Rate();
        $rate = Rate::find($id);
        $rate->delete();
        return response()->json(['success'=>1,'data'=>$rate], 200);
    }

    public function updateRate(Request $request)
    {
        $input=($request->json()->all());
        $newData=(object)($input['rateData']);
        $rate = new Rate();
        $rate = Rate::find($newData->id);
        $rate->price_code_id = $newData->price_code_id;
        $rate->p_loss = $newData->p_loss;
        $rate->price = $newData->price;
        $rate->customer_category_id = $newData->customer_category_id;
        $rate-> update();

        $rate->customer_category_name = (CustomerCategory::select('customer_category_name')
            ->where('id','=',$rate->customer_category_id)
            ->get())[0] -> customer_category_name;

        $rate->price_code_name = (PriceCode::select('price_code_name')
            ->where('id','=',$rate->price_code_id)
            ->get())[0] -> price_code_name;

        return response()->json(['success'=>1,'data'=>$rate], 200);
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
