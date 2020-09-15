<?php

namespace App\Http\Controllers;

use App\Model\JobDetail;
use App\Model\JobMaster;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\CustomVoucher;

class JobMasterController extends Controller
{

    public function saveJob(Request $request)
    {
        $input=($request->json()->all());

        $inputJobMaster=(object)($input['master']);
        $inputJobDetails=(object)($input['details']);

        $temp_date = explode("-",$inputJobMaster->date);
        $accounting_year="";
        if($temp_date[1]>3){
            $x = $temp_date[0]%100;
            $accounting_year = $x*100 + ($x+1);
        }else{
            $x = $temp_date[0]%100;
            $accounting_year =($x-1)*100+$x;
        }

        $customVoucher=CustomVoucher::where('voucher_name',"job")->Where('accounting_year',$accounting_year)->first();

        if($customVoucher) {
            $customVoucher->last_counter = $customVoucher->last_counter + 1;
            $customVoucher->save();
        }else{
            $customVoucher= new CustomVoucher();
            $customVoucher->voucher_name="job";
//            $customVoucher->accounting_year=$inputOrderMaster->accounting_year;
            $customVoucher->accounting_year=$accounting_year;
            $customVoucher->last_counter=1;
            $customVoucher->delimiter='/';
            $customVoucher->prefix='JOB';
            $customVoucher->save();
        }
            $data=JobMaster::select()->where('order_details_id',$inputJobMaster->order_details_id)->first();

            if($data){
                $jobDetails=new JobDetail();
                $jobDetails->job_master_id=$data->id;
                $jobDetails->employee_id=$inputJobDetails->employee_id;
                $jobDetails->material_id=$inputJobDetails->material_id;
                $jobDetails->job_task_id=1;
                $jobDetails->material_quantity=$inputJobDetails->material_quantity;
                $jobDetails->save();
            }else{
                $jobMaster= new JobMaster();
                $voucherNumber=$customVoucher->prefix
                    .$customVoucher->delimiter
                    .str_pad($customVoucher->last_counter,6,'0',STR_PAD_LEFT)
                    .$customVoucher->delimiter
                    .$customVoucher->accounting_year;
                $jobMaster->job_number=$voucherNumber;
                $jobMaster->date=$inputJobMaster->date;
                $jobMaster->karigarh_id=$inputJobMaster->karigarh_id;
                $jobMaster->order_details_id=$inputJobMaster->order_details_id;
//                $jobMaster->gross_weight=$inputJobMaster->gross_weight;
                $jobMaster->status_id=1;
                $jobMaster->save();

                $jobDetails=new JobDetail();
                $jobDetails->job_master_id=$jobMaster->id;
                $jobDetails->employee_id=$inputJobDetails->employee_id;
                $jobDetails->material_id=$inputJobDetails->material_id;
                $jobDetails->job_task_id=1;
                $jobDetails->material_quantity=$inputJobDetails->material_quantity;
                $jobDetails->save();

                if($jobDetails) {
                    $orderDetails= new OrderDetail();
                    $orderDetails=OrderDetail::find($inputJobMaster->order_details_id);
                    $orderDetails->status_id=1;
                    $orderDetails->update();
                }

            }
        return response()->json(['success'=>1,'data'=> $jobDetails], 200);
    }


    public function updateGrossWeight(Request $request)
    {
        $input=($request->json()->all());
        $inputJobMaster=(object)($input['master']);
        $jobMaster = new JobMaster();
        $jobMaster = JobMaster::find($inputJobMaster->id);
        $jobMaster->gross_weight = $inputJobMaster->gross_weight;
        $jobMaster->update();
        if($jobMaster){
//            $jobMaster = new JobMaster();
//            $jobMaster = JobMaster::find($inputJobMaster->id);
            $jobMaster->status_id =100;
            $jobMaster->update();

            $orderDetail = new OrderDetail();
            $orderDetail = OrderDetail::find($jobMaster->order_details_id);
            $orderDetail->status_id = 100;
            $orderDetail->update();
        }
        return response()->json(['success'=>1,'data'=> $jobMaster], 200);
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
     * @param  \App\Model\JobMaster  $jobMaster
     * @return \Illuminate\Http\Response
     */
    public function show(JobMaster $jobMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\JobMaster  $jobMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(JobMaster $jobMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\JobMaster  $jobMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobMaster $jobMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\JobMaster  $jobMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobMaster $jobMaster)
    {
        //
    }
}
