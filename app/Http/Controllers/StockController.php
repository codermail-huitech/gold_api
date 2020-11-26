<?php

namespace App\Http\Controllers;

use App\Model\CustomVoucher;
use App\Model\JobDetail;
use App\Model\JobMaster;
use App\Model\OrderDetail;
use App\Model\Stock;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Hexadecimal;


class StockController extends Controller
{

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
                $customVoucher->accounting_year=2020;
                $customVoucher->last_counter=1;
                $customVoucher->delimiter='-';
                $customVoucher->prefix='STOCK';
                $customVoucher->save();
            }
                    $newStock = new Stock();
                    $newStock->job_master_id = $items['job_master_id'];
                    $newStock->tag =$items['job_number']
                        .$customVoucher->delimiter
                        .$customVoucher->last_counter;
                    $newStock->gold = $items['set_gold'];
                    $newStock->amount = $items['set_amount'];
                    $newStock->quantity = $items['set_quantity'];
                    $newStock->size = $items['size'];
                    $newStock->material_id = $items['material_id'];
                    $newStock->gross_weight = $items['set_gross_weight'];
                    $newStock->agent_id = 2;
                    $newStock->save();

                    if($newStock){
                        $jobMaster = JobMaster::find($newStock->job_master_id);
                        $jobMaster->status_id = 102;
                        $jobMaster->save();
                    }
                array_push($newData,$newStock );
        }
        return response()->json(['success' => 1, 'data' => $newData], 200, [], JSON_NUMERIC_CHECK);
    }


    public function getStockCustomer(){
        $stockCustomer = JobMaster::select('users.id','users.person_name')
                         ->join('order_details','order_details.id','=','job_masters.order_details_id')
                         ->join('order_masters','order_masters.id','=','order_details.order_master_id')
                         ->join('users','users.id','=','order_masters.person_id')
                         ->where('job_masters.status_id',100)
                         ->where('job_masters.bill_created',0)
                         ->first();

        return response()->json(['success'=>1,'data'=>$stockCustomer],200,[],JSON_NUMERIC_CHECK);
    }

    public function getRecordByJobMasterId($id){
        $record = OrderDetail::select(DB::raw("order_details.id as order_details_id"),'job_masters.job_number',DB::raw("job_masters.id as job_master_id"),DB::raw("concat(products.model_number,'-',products.product_name,'-',job_masters.job_number) as order_name"),'order_details.price','order_details.approx_gold','order_details.size','order_details.quantity','order_details.product_id','products.model_number','products.product_name','order_masters.person_id','order_masters.agent_id','order_masters.order_number','users.person_name','job_masters.status_id','job_masters.bill_created','job_masters.gross_weight','job_details.material_id','job_details.job_task_id')
            ->join('products','products.id','=','order_details.product_id')
            ->join('order_masters','order_masters.id','=','order_details.order_master_id')
            ->join('users','users.id','=','order_masters.person_id')
            ->join('job_masters','job_masters.order_details_id','=','order_details.id')
            ->join('job_details','job_details.job_master_id','=','job_masters.id')
            ->where('job_masters.id',$id)
            ->where('job_details.job_task_id',1)
            ->distinct()
            ->get();

        return response()->json(['success'=>1,'data'=>$record],200,[],JSON_NUMERIC_CHECK);
    }

    public function getStockList()
    {
//        $data = Stock::select('stocks.id','stocks.gold', 'stocks.agent_id' , 'stocks.amount', 'stocks.in_stock','stocks.quantity', 'stocks.gross_weight','stocks.material_id','products.model_number', 'stocks.tag','stocks.job_master_id','order_details.size', DB::raw("users.id as person_id"))
//                ->join('job_masters','job_masters.id','=','stocks.job_master_id')
////                ->join('job_details','job_details.job_master_id','=','job_masters.id')
//                ->join('order_details','order_details.id','=','job_masters.order_details_id')
//                ->join('order_masters','order_masters.id','=','order_details.order_master_id')
//                ->join('users','users.id','=','order_masters.person_id')
//                ->join('products','products.id','=','order_details.product_id')
//                ->where('stocks.in_stock',1)
//                ->get();

////        $data = Stock::select('stocks.id','stocks.gold', 'stocks.agent_id' , 'stocks.amount', 'stocks.in_stock','stocks.quantity', 'stocks.gross_weight','stocks.material_id','products.model_number', 'stocks.tag','stocks.job_master_id','order_details.size', DB::raw("users.id as person_id"))
//        $data = Stock::select('stocks.id','stocks.gold', 'stocks.agent_id' , 'stocks.amount', 'stocks.in_stock','stocks.quantity', 'stocks.gross_weight','stocks.material_id','products.model_number',
//
//
//            DB::raw("select concat(SUBSTRING(tag, 5,5),'-' ,
//                           SUBSTRING_INDEX(SUBSTRING_INDEX(tag,'-',-2), '-',1),'-',
//                           SUBSTRING_INDEX(tag,'-',-1)) as tag")
//
//
//            ,'stocks.job_master_id','order_details.size', DB::raw("users.id as person_id"))
//            ->join('job_masters','job_masters.id','=','stocks.job_master_id')
////                ->join('job_details','job_details.job_master_id','=','job_masters.id')
//            ->join('order_details','order_details.id','=','job_masters.order_details_id')
//            ->join('order_masters','order_masters.id','=','order_details.order_master_id')
//            ->join('users','users.id','=','order_masters.person_id')
//            ->join('products','products.id','=','order_details.product_id')
//            ->where('stocks.in_stock',1)
//            ->get();
//        foreach ($data as $newData){
//            $pieces = explode("-", $newData['tag']);
//            $newData['tag'] = dechex($pieces[1]).'-'.dechex($pieces[2]).'-'.$pieces[3];
//        }

//        return $result;
        $queryResult = DB::select('call getStockWithTag()');
        $result = collect($queryResult);

        return response()->json(['success'=>1,'data'=> $result],200,[],JSON_NUMERIC_CHECK);
    }

    public function updateStockByAgentId(Request $request)
    {
        $input=($request->json()->all());
        $stockList=($input['stockList']);
        $agentId=($input['agentId']);

        $newStock = new Stock();
        foreach ($stockList as $stockData) {
            $newStock = Stock::find($stockData['id']);
            $newStock->agent_id = $agentId;
            $newStock->update();
        }

        return response()->json(['success'=>1,'data'=>$newStock], 200,[],JSON_NUMERIC_CHECK);
    }

    public function updateStockByDefaultAgentId(Request $request)
    {
        $input=($request->json()->all());
        $stockList=($input['stockList']);

        $newStock = new Stock();
        foreach ($stockList as $singleList){
            $newStock = Stock::find($singleList['id']);
            $newStock->agent_id = 2;
            $newStock->update();
        }

        return response()->json(['success'=>1,'data'=>$newStock], 200,[],JSON_NUMERIC_CHECK);
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
