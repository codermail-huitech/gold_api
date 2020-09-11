<?php

namespace App\Http\Controllers;

use App\Model\BillDetail;
use App\Model\BillMaster;
use App\Model\CustomVoucher;
use App\Model\JobMaster;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\DB;

class BillMasterController extends Controller
{

    public function saveBillMaster(Request $request)
    {
        $newData = ($request->json()->all());
        $master=(object)($newData['master']);
        $details=$newData['details'];

//        return response()->json(['success'=>1, 'data'=>$details],200,[],JSON_NUMERIC_CHECK);
        DB::beginTransaction();

        $customVoucher=CustomVoucher::where('voucher_name',"bill")->Where('accounting_year',"2020")->first();

        if($customVoucher) {
            $customVoucher->last_counter = $customVoucher->last_counter + 1;
            $customVoucher->save();
        }else{
            $customVoucher= new CustomVoucher();
            $customVoucher->voucher_name="bill";
//            $customVoucher->accounting_year=$inputOrderMaster->accounting_year;
            $customVoucher->accounting_year="2020";
            $customVoucher->last_counter=1;
            $customVoucher->delimiter='/';
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
            $result->bill_date = $master->billDate;
            $result->karigarh_id = $master->karigarhId;
            $result->customer_id = $master->customerId;
            $result->discount = $master->discount;
            $result->save();

            if ($result) {
                foreach ($details as $newData) {
                    $newResult = new BillDetail();
                    $newResult->bill_master_id = $result->id;
//                    $newResult->order_master_id = $newData->order_master_id;
                    $newResult->order_master_id = $newData['order_master_id'];
                    $newResult->job_master_id = $newData['id'];
                    $newResult->save();
                    if($newResult){
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

        return response()->json(['success'=>1, 'data'=>$result],200,[],JSON_NUMERIC_CHECK);
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
