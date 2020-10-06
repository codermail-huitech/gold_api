<?php

namespace App\Http\Controllers;

use App\Model\LCReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LCReceivedController extends Controller
{
    public function SaveReceivedGold()
    {
        $result = LCReceived::select('lc_receiveds.id','lc_receiveds.customer_id','lc_receiveds.agent_id','lc_receiveds.gold_received','lc_receiveds.received_date',DB::raw('customers.person_name as customer_name ,agents.person_name as agent_name'))
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
     * @param  \App\Model\LCReceived  $lCReceived
     * @return \Illuminate\Http\Response
     */
    public function show(LCReceived $lCReceived)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\LCReceived  $lCReceived
     * @return \Illuminate\Http\Response
     */
    public function edit(LCReceived $lCReceived)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\LCReceived  $lCReceived
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LCReceived $lCReceived)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\LCReceived  $lCReceived
     * @return \Illuminate\Http\Response
     */
    public function destroy(LCReceived $lCReceived)
    {
        //
    }
}
