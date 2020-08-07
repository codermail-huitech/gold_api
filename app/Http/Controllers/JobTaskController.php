<?php

namespace App\Http\Controllers;

use App\Model\JobTask;
use Illuminate\Http\Request;
use App\Model\OrderDetail;
use App\Model\OrderMaster;
use App\Model\JobMaster;
use App\Model\JobDetail;

class JobTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getSavedJobs()
    {
        $data=JobMaster::select('job_masters.id','job_masters.job_number','job_masters.order_details_id','job_masters.karigarh_id','job_masters.date','order_details.quantity','order_details.size','order_details.material_id','order_details.product_id','order_details.p_loss','products.model_number','order_masters.order_number','order_masters.date_of_delivery','materials.material_name')
              ->join('order_details','job_masters.order_details_id','order_details.id')
              ->join('materials','order_details.material_id','materials.id')
              ->join('order_masters','order_details.order_master_id','=','order_masters.id')
              ->join('products','order_details.product_id','=','products.id')
              ->where('order_details.job_status','=',1)

              ->get();



        return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);

    }

    public function saveReturn(Request $request)
    {
        $input=$request->json()->all();
        $data=(object)($input['data']);

        $jobDetails=new JobDetail();
//        $jobDetails->job_master_id=JobMaster::find($data->id)->id;
        $jobDetails->job_master_id= $data->id;
        $jobDetails->employee_id= $data->employee_id;
        $jobDetails->material_id=$data->material_id;
        $jobDetails->job_task_id=$data->job_Task_id;
        $jobDetails->material_quantity=$data->return_quantity;
        $jobDetails->save();

        return response()->json(['success'=>1,'data'=>$jobDetails], 200,[],JSON_NUMERIC_CHECK);
    }

    public function getJobTaskData(Request $request){

        $input=$request->json()->all();
        $data=(object)($input['data']);

        $goldReturnData = JobDetail:: select()
                          ->where('job_task_id','=',$data->job_Task_id)
                          ->where('job_master_id','=',$data->id)
                          ->get();


        return response()->json(['success'=>1,'data'=> $goldReturnData], 200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Model\JobTask  $jobTask
     * @return \Illuminate\Http\Response
     */
    public function show(JobTask $jobTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\JobTask  $jobTask
     * @return \Illuminate\Http\Response
     */
    public function edit(JobTask $jobTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\JobTask  $jobTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobTask $jobTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\JobTask  $jobTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobTask $jobTask)
    {
        //
    }
}
