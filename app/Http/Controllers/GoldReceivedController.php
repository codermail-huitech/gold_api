<?php

namespace App\Http\Controllers;

use App\Model\BillMaster;
use App\Model\GoldReceived;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoldReceivedController extends Controller
{
    public function getCompletedBills()
    {
        $result = GoldReceived:: select('gold_receiveds.id','gold_receiveds.customer_id','gold_receiveds.agent_id','gold_receiveds.gold_received','gold_receiveds.received_date',DB::raw('customers.person_name as customer_name ,agents.person_name as agent_name'))
                                 ->join('users as customers','customers.id','gold_receiveds.customer_id')
                                 ->join('users as agents','agents.id','gold_receiveds.agent_id')
                                 ->get();
        return response()->json(['success'=>1,'data'=>$result],200,[],JSON_NUMERIC_CHECK);
    }

    public function SaveReceivedGold(Request $request)
    {
        $input = $request->json()->all();

        $goldReceived = new GoldReceived();
        $goldReceived->customer_id = $input['customer_id'];
        $goldReceived->agent_id = $input['agent_id'];
        $goldReceived->received_date = $input['received_date'];
        $goldReceived->gold_received = $input['gold_received'];
        $goldReceived->save();
        $goldReceived->customer_name = (User::select('person_name')->where( 'id',$goldReceived->customer_id)->first())->person_name;
        $goldReceived->agent_name = (User::select('person_name')->where('id', $goldReceived->agent_id)->first())->person_name;

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
