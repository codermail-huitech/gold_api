<?php

namespace App\Http\Controllers;

use App\Model\CustomVoucher;
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
        $orderData = OrderDetail::select('order_details.id',DB::raw("job_masters.id as job_master_id"),DB::raw("concat(products.model_number,'-',products.product_name,'-',users.person_name) as order_name"),'order_details.order_master_id','order_details.price','order_details.approx_gold','order_details.quantity','order_details.product_id','products.model_number','products.product_name','order_masters.person_id','order_masters.order_number','users.person_name')
                     ->join('products','products.id','=','order_details.product_id')
                     ->join('order_masters','order_masters.id','=','order_details.order_master_id')
                     ->join('users','users.id','=','order_masters.person_id')
                     ->join('job_masters','job_masters.order_details_id','=','order_details.id')
                     ->get();

        return response()->json(['success'=>1,'data'=>$orderData],200,[],JSON_NUMERIC_CHECK);
    }

    public function saveStock(Request $request)
    {
        $input = ($request->json()->all());
        $newData = array();
        foreach ($input as $items){

            $customVoucher=CustomVoucher::where('voucher_name',$items['job_master_id'])->Where('accounting_year',2020)->first();

            if($customVoucher) {
                $customVoucher->last_counter = $customVoucher->last_counter + 1;
                $customVoucher->save();
            }else{
                $customVoucher= new CustomVoucher();
                $customVoucher->voucher_name=$items['job_master_id'];
    //            $customVoucher->accounting_year=$inputOrderMaster->accounting_year;
                $customVoucher->accounting_year=2020;
                $customVoucher->last_counter=1;
                $customVoucher->delimiter='-';
                $customVoucher->prefix='STOCK';
                $customVoucher->save();
            }
            $data = $customVoucher->voucher_name.$customVoucher->delimiter.$customVoucher->last_counter;
            array_push($newData,$data );
        }
//        $data = $customVoucher->voucher_name.$customVoucher->delimiter.$customVoucher->last_counter;

        return response()->json(['success' => 1, 'data' => $newData], 200, [], JSON_NUMERIC_CHECK);
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
