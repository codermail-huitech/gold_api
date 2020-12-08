<?php

namespace App\Http\Controllers;

use App\Model\BillDetail;
use App\Model\BillMaster;
use App\Model\CustomVoucher;
use App\Model\JobMaster;
use App\Model\OrderDetail;
use App\Model\Stock;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\DB;

class BillMasterController extends Controller
{

    public function saveBillMaster(Request $request)
    {

        $newData = ($request->json()->all());
//        $master=(object)($newData['master']);
        $master=$newData['master'];
        $details=$newData['details'];



        DB::beginTransaction();
        $temp_date = explode("-",$master['billDate']);
        $accounting_year='';
        if($temp_date[1]>3){
            $x = $temp_date[0]%100;
            $accounting_year = $x*100 + ($x+1);
        }else{
            $x = $temp_date[0]%100;
            $accounting_year =($x-1)*100+$x;
        }
        $customVoucher=CustomVoucher::where('voucher_name',"bill")->Where('accounting_year',$accounting_year)->first();
        if($customVoucher) {
            $customVoucher->last_counter = $customVoucher->last_counter + 1;
            $customVoucher->save();
        }else{
            $customVoucher= new CustomVoucher();
            $customVoucher->voucher_name="bill";
//            $customVoucher->accounting_year=$inputOrderMaster->accounting_year;
            $customVoucher->accounting_year=$accounting_year;
            $customVoucher->last_counter=1;
            $customVoucher->delimiter='-';
            $customVoucher->prefix='BILL';
            $customVoucher->save();
        }


        try {
            $result = new BillMaster();
            $result->bill_number = $customVoucher->prefix
                . $customVoucher->delimiter
                . str_pad($customVoucher->last_counter, 5, '0', STR_PAD_LEFT)
                . $customVoucher->delimiter
                . $customVoucher->accounting_year;
            $result->bill_date = $master['billDate'];
            $result->customer_id = $master['customerId'];
            if(array_key_exists('order_master_id',$master)){
                $result->order_master_id = $master['order_master_id'];
            }
//            else{
//                $result->order_master_id = 0;
//            }
            $result->agent_id = $master['agent_id'];
            $result->discount = $master['discount'];
            $result->save();

            if ($result) {
                foreach ($details as $newDetails) {
                    $newResult = new BillDetail();
                    $newResult->bill_master_id = $result->id;

//                    $newResult->order_master_id = $master->order_master_id;
//                    $newResult->order_master_id = $newData['order_master_id'];
                    if(array_key_exists("tag",$newDetails)){
                        $newResult->tag = $newDetails['tag'];
                    }
                    else{
                        $newResult->job_master_id = $newDetails['id'];
                    }

                    $newResult->model_number = $newDetails['model_number'];
                    $newResult->size = $newDetails['size'];
                    $newResult->gross_weight = $newDetails['gross_weight'];
                    $newResult->material_id = $newDetails['material_id'];
                    $newResult->ginnie = $newDetails['total'];
                    $newResult->rate = $newDetails['price'];
                    $newResult->pure_gold = $newDetails['pure_gold'];
                    $newResult->quantity = $newDetails['quantity'];
                    $newResult->LC =$newDetails['cost'];
                    $newResult->save();
                    if($newResult && array_key_exists('tag',$newDetails)){
                       $stock = new Stock();
                       $stock = Stock::find($newDetails['id']);
                       $stock->in_stock = 0;
                       $stock->update();
//                        return response()->json(['stock'=>$stock],200,[],JSON_NUMERIC_CHECK);
                    }
                    else {
                        $jobMaster = new JobMaster();
                        $jobMaster = JobMaster::find($newResult->job_master_id);
                        $jobMaster->bill_created = 1;
                        $jobMaster->update();
                        if($jobMaster){
                            $orderDetails = new OrderDetail();
                            $orderDetails = OrderDetail::find($jobMaster->order_details_id);
                            $orderDetails->bill_created = 1;
                            $orderDetails->update();
                        }
                    }
                }

            }
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['Success'=>1,'Exception'=>$e], 401);
        }

        return response()->json(['success'=>1, 'data'=> $result],200,[],JSON_NUMERIC_CHECK);
    }


    public function testBillSave(Request $request){

        $newData = ($request->json()->all());
        $details=$newData['details'];

        foreach ($details as $newDetails) {
            $newResult = new BillDetail();
//                    $newResult->bill_master_id = $result->id;
            $newResult->bill_master_id = 1;

            if (array_key_exists("tag", $newDetails)) {
                $newResult->tag = $newDetails['tag'];

            }
            else
            {
                $newResult->job_master_id = (string)$newDetails['id'];
            }


            $newResult->model_number = $newDetails['model_number'];
            $newResult->size = $newDetails['size'];
            $newResult->gross_weight = $newDetails['gross_weight'];
            $newResult->material_id = $newDetails['material_id'];
            $newResult->ginnie = $newDetails['total'];
            $newResult->rate = $newDetails['rate'];
            $newResult->pure_gold = $newDetails['pure_gold'];

            $newResult->quantity = $newDetails['quantity'];
            $newResult->LC = $newDetails['cost'];
            $newResult->save();
        }
        return response()->json(['success'=>1, 'result'=>$details],200,[],JSON_NUMERIC_CHECK);
    }

    public function getFinishedBillData(Request $request)
    {
        $input = ($request->json()->all());
        $data = JobMaster::select('bill_masters.bill_number','bill_masters.id','bill_masters.discount')
            ->join('users as karigarh', 'job_masters.karigarh_id', '=', 'karigarh.id')
            ->join('order_details', 'job_masters.order_details_id', '=', 'order_details.id')
            ->join('order_masters', 'order_details.order_master_id', '=', 'order_masters.id')
            ->join('bill_masters', 'bill_masters.order_master_id', '=', 'order_masters.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->where('job_masters.bill_created','=',1)
            ->where('order_masters.id', '=', $input)
            ->distinct()
            ->get();
        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

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
     * @param  \App\Model\BillMaster  $billMaster
     * @return \Illuminate\Http\Response
     */
    public function show(BillMaster $billMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\BillMaster  $billMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(BillMaster $billMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\BillMaster  $billMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BillMaster $billMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\BillMaster  $billMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillMaster $billMaster)
    {
        //
    }
}
