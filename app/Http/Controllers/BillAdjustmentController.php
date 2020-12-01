<?php

namespace App\Http\Controllers;

use App\Model\BillAdjustment;
use Illuminate\Http\Request;

class BillAdjustmentController extends Controller
{
    public function getBillAdjustment()
    {
        $data = BillAdjustment::select()->get();
        return response()->json(['success'=>1,'data'=>$data],200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Model\BillAdjustment  $billAdjustment
     * @return \Illuminate\Http\Response
     */
    public function show(BillAdjustment $billAdjustment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\BillAdjustment  $billAdjustment
     * @return \Illuminate\Http\Response
     */
    public function edit(BillAdjustment $billAdjustment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\BillAdjustment  $billAdjustment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BillAdjustment $billAdjustment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\BillAdjustment  $billAdjustment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillAdjustment $billAdjustment)
    {
        //
    }
}
