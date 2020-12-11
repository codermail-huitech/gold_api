<?php

namespace App\Http\Controllers;

use App\Model\PaymentGold;
use Illuminate\Http\Request;
use App\Model\CustomVoucher;

class PaymentGoldController extends Controller
{
    public function saveGoldPayment(Request $request)
    {
        $input = (object)($request->json()->all());

        $temp_date = explode("-",$input->received_date);
        if($temp_date[1]>3){
            $x = $temp_date[0]%100;
            $accounting_year = $x*100 + ($x+1);
        }else{
            $x = $temp_date[0]%100;
            $accounting_year =($x-1)*100+$x;
        }

        $customVoucher=CustomVoucher::where('voucher_name','goldReceived')->Where('accounting_year',$accounting_year)->first();

        if($customVoucher) {
            $customVoucher->last_counter = $customVoucher->last_counter + 1;
            $customVoucher->save();
        }else{
            $customVoucher= new CustomVoucher();
            $customVoucher->voucher_name='goldReceived';
            $customVoucher->accounting_year=$accounting_year;
            $customVoucher->last_counter=1;
            $customVoucher->delimiter='-';
            $customVoucher->prefix='GR';
            $customVoucher->save();
        }

        $result = new PaymentGold();
        $result->person_id = $input->person_id;
        $result->transaction_id = $customVoucher->prefix.$customVoucher->last_counter;
        $result->agent_id = $input->agent_id;
        $result->gold_received = $input->gold_received;
        $result->received_date = $input->received_date;
        $result->save();
        return response()->json(['success'=>1,'data'=>$input],200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Model\PaymentGold  $paymentGold
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentGold $paymentGold)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\PaymentGold  $paymentGold
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentGold $paymentGold)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\PaymentGold  $paymentGold
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentGold $paymentGold)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\PaymentGold  $paymentGold
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentGold $paymentGold)
    {
        //
    }
}
