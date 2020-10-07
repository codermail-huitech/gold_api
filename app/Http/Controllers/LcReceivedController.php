<?php

namespace App\Http\Controllers;

use App\Model\GoldReceived;
use App\Model\LcReceived;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class LcReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SaveReceivedGold()
    {
        $result = LCReceived::select('lc_receiveds.id','lc_receiveds.customer_id','lc_receiveds.agent_id','lc_receiveds.lc_received','lc_receiveds.received_date',DB::raw('customers.person_name as customer_name ,agents.person_name as agent_name'))
            ->join('users as customers','customers.id','lc_receiveds.customer_id')
            ->join('users as agents','agents.id','lc_receiveds.agent_id')
            ->get();
        return response()->json(['success'=>1,'data'=>$result],200,[],JSON_NUMERIC_CHECK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SaveLCReceived(Request $request)
    {
        $input = $request->json()->all();

        $lcReceived = new LcReceived();
        $lcReceived->customer_id = $input['customer_id'];
        $lcReceived->agent_id = $input['agent_id'];
//        $lcReceived->bill_master_id = $input['bill_master_id'];
        $lcReceived->received_date = $input['received_date'];
        $lcReceived->lc_received = $input['lc_received'];
        $lcReceived->save();

        $lcReceived->customer_name = (User::select('person_name')->where( 'id',$lcReceived->customer_id)->first())->person_name;
        $lcReceived->agent_name = (User::select('person_name')->where('id', $lcReceived->agent_id)->first())->person_name;

        return response()->json(['success'=>1,'data'=>$lcReceived],200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Model\LcReceived  $lcReceived
     * @return \Illuminate\Http\Response
     */
    public function show(LcReceived $lcReceived)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\LcReceived  $lcReceived
     * @return \Illuminate\Http\Response
     */
    public function edit(LcReceived $lcReceived)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\LcReceived  $lcReceived
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LcReceived $lcReceived)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\LcReceived  $lcReceived
     * @return \Illuminate\Http\Response
     */
    public function destroy(LcReceived $lcReceived)
    {
        //
    }
}
