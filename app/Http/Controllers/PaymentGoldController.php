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

        $customVoucher=CustomVoucher::where('voucher_name','goldReceived')->Where('accounting_year',2021)->first();

        if($customVoucher) {
            $customVoucher->last_counter = $customVoucher->last_counter + 1;
            $customVoucher->save();
        }else{
            $customVoucher= new CustomVoucher();
            $customVoucher->voucher_name='goldReceived';
            $customVoucher->accounting_year=2021;
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
