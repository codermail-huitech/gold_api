<?php

namespace App\Http\Controllers;

use App\Model\BillMaster;
use App\Model\GoldReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoldReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompletedBills()
    {
        $result = BillMaster::select( 'bill_masters.id','bill_masters.bill_number','order_masters.agent_id','gold_receiveds.gold_received',DB::raw('customers.person_name as customer_name , customers.id  as customer_id,agents.person_name as agent_name, agents.id as agent_id'))
                  ->leftJoin('gold_receiveds','gold_receiveds.bill_master_id','bill_masters.id')
                  ->join('users as customers','customers.id','bill_masters.customer_id')
                  ->join('order_masters','order_masters.id','bill_masters.order_master_id')
                  ->join('users as agents','agents.id','order_masters.agent_id')
                  ->get();

        return response()->json(['success'=>1,'data'=>$result],200,[],JSON_NUMERIC_CHECK);
    }


    public function SaveReceivedGold(Request $request)
    {
        $input = $request->json()->all();

        $goldReceived = new GoldReceived();
        $goldReceived->customer_id = $input['customer_id'];
        $goldReceived->agent_id = $input['agent_id'];
        $goldReceived->bill_master_id = $input['bill_master_id'];
        $goldReceived->received_date = $input['received_date'];
        $goldReceived->gold_received = $input['gold_received'];
        $goldReceived->save();

        return response()->json(['success'=>1,'data'=>$goldReceived],200,[],JSON_NUMERIC_CHECK);

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
     * @param  \App\Model\GoldReceived  $goldReceived
     * @return \Illuminate\Http\Response
     */
    public function show(GoldReceived $goldReceived)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\GoldReceived  $goldReceived
     * @return \Illuminate\Http\Response
     */
    public function edit(GoldReceived $goldReceived)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\GoldReceived  $goldReceived
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoldReceived $goldReceived)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\GoldReceived  $goldReceived
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoldReceived $goldReceived)
    {
        //
    }
}
