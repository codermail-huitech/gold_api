<?php

namespace App\Http\Controllers;

use App\Model\CustomVoucher;
use App\Model\PaymentCash;
use Illuminate\Http\Request;

class PaymentCashController extends Controller
{
    public function saveCashPayment(Request $request)
    {
        $input = (object)($request->json()->all());

        $customVoucher=CustomVoucher::where('voucher_name','cashReceived')->Where('accounting_year',2021)->first();

        if($customVoucher) {
            $customVoucher->last_counter = $customVoucher->last_counter + 1;
            $customVoucher->save();
        }else{
            $customVoucher= new CustomVoucher();
            $customVoucher->voucher_name='cashReceived';
            $customVoucher->accounting_year=2021;
            $customVoucher->last_counter=1;
            $customVoucher->delimiter='-';
            $customVoucher->prefix='CR';
            $customVoucher->save();
        }

        $result = new PaymentCash();
        $result->person_id = $input->person_id;
        $result->transaction_id = $customVoucher->prefix.$customVoucher->last_counter;
        $result->agent_id = $input->agent_id;
        $result->cash_received = $input->cash_received;
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
     * @param  \App\Model\PaymentCash  $paymentCash
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentCash $paymentCash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\PaymentCash  $paymentCash
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentCash $paymentCash)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\PaymentCash  $paymentCash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentCash $paymentCash)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\PaymentCash  $paymentCash
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentCash $paymentCash)
    {
        //
    }
}
