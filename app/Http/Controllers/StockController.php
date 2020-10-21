<?php

namespace App\Http\Controllers;

use App\Model\CustomVoucher;
use App\Model\JobDetail;
use App\Model\JobMaster;
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
        $orderData = OrderDetail::select(DB::raw("order_details.id as order_details_id"),DB::raw("job_masters.id as job_master_id"),DB::raw("concat(products.model_number,'-',products.product_name,'-',job_masters.job_number) as order_name"),'order_details.price','order_details.approx_gold','order_details.quantity','order_details.product_id','products.model_number','products.product_name','order_masters.person_id','order_masters.order_number','users.person_name','job_masters.status_id','job_masters.bill_created')
                     ->join('products','products.id','=','order_details.product_id')
                     ->join('order_masters','order_masters.id','=','order_details.order_master_id')
                     ->join('users','users.id','=','order_masters.person_id')
                     ->join('job_masters','job_masters.order_details_id','=','order_details.id')
                     ->where('job_masters.status_id',100)
                     ->where('job_masters.bill_created',0)
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

                    $newStock = new Stock();
                    $newStock->job_master_id = $items['job_master_id'];
                    $newStock->tag =$customVoucher->voucher_name
                        .$customVoucher->delimiter
                        .$customVoucher->last_counter;
                    $newStock->gold = $items['set_gold'];
                    $newStock->amount = $items['set_amount'];
                    $newStock->quantity = $items['set_quantity'];
                    $newStock->save();

                    if($newStock){
                        $jobMaster = JobMaster::find($newStock->job_master_id);
                        $jobMaster->status_id = 102;
                        $jobMaster->save();
                    }
//            return response()->json(['success' => 1, 'data' => $newStock], 200, [], JSON_NUMERIC_CHECK);
                array_push($newData,$newStock );
        }
//        $data = $customVoucher->voucher_name.$customVoucher->delimiter.$customVoucher->last_counter;
        return response()->json(['success' => 1, 'data' => $newData], 200, [], JSON_NUMERIC_CHECK);
    }


    public function getStockCustomer(){
        $stockCustomer = JobMaster::select('users.id','users.person_name')
                         ->join('order_details','order_details.id','=','job_masters.order_details_id')
                         ->join('order_masters','order_masters.id','=','order_details.order_master_id')
                         ->join('users','users.id','=','order_masters.person_id')
                         ->where('job_masters.status_id',100)
                         ->where('job_masters.bill_created',0)
//                         ->distinct()
                         ->first();

        return response()->json(['success'=>1,'data'=>$stockCustomer],200,[],JSON_NUMERIC_CHECK);
    }


    public function fetchingStockByJobMasterId($id)
    {
//        return response()->json(['success'=>1,'data'=>$id],200,[],JSON_NUMERIC_CHECK);
        $stockData = OrderDetail::select(DB::raw("users.person_name as person_name"),DB::raw("order_details.id as order_details_id"),DB::raw("job_masters.id as job_master_id"),DB::raw("concat(products.model_number,'-',products.product_name,'-',job_masters.job_number) as order_name"),'order_details.price','order_details.approx_gold','order_details.quantity','order_details.product_id','products.model_number','products.product_name','order_masters.person_id','order_masters.order_number','users.person_name','job_masters.status_id','job_masters.bill_created')
            ->join('products','products.id','=','order_details.product_id')
            ->join('order_masters','order_masters.id','=','order_details.order_master_id')
            ->join('users','users.id','=','order_masters.person_id')
            ->join('job_masters','job_masters.order_details_id','=','order_details.id')
//            ->where('job_masters.status_id','<>',102)
//            ->where('job_masters.bill_created',0)
            ->where('job_masters.id',$id)
            ->get();
        return response()->json(['success'=>1,'data'=>$stockData],200,[],JSON_NUMERIC_CHECK);
    }

    public function fetchingStocks()
    {
        $data = Stock::select(DB::raw("concat(products.model_number,'-',products.product_name,'-',job_masters.job_number) as order_name"),'users.id','stocks.gold', 'stocks.amount', 'stocks.quantity', 'users.person_name')
            ->join('job_masters','job_masters.id','=','stocks.job_master_id')
            ->join('job_details','job_details.job_master_id','=','job_masters.id')
            ->join('order_details','order_details.id','=','job_masters.order_details_id')
            ->join('order_masters','order_masters.id','=','order_details.order_master_id')
            ->join('users','users.id','=','order_masters.person_id')
            ->join('products','products.id','=','order_details.product_id')
            ->get();
        return response()->json(['success'=>1,'data'=>$data],200,[],JSON_NUMERIC_CHECK);
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
