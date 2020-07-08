<?php

namespace App\Http\Controllers;

use App\Model\JobTask;
use Illuminate\Http\Request;
use App\Model\OrderDetail;
use App\Model\OrderMaster;

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
        $data=OrderDetail::select('order_masters.order_number','order_details.price','order_details.p_loss','order_details.approx_gold','order_details.quantity','order_details.size')
              ->join('order_masters','order_details.order_master_id','=','order_masters.id')
              ->where('order_details.job_status','=',1)
              ->get();

       
              
        return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);      

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
