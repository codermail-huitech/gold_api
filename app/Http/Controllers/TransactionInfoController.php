<?php

namespace App\Http\Controllers;

use App\Model\TransactionInfo;
use Illuminate\Http\Request;
use App\User;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class TransactionInfoController extends Controller
{

    public function saveTransaction(Request $request)
    {
        $input=(object)($request->json()->all());
//        return  response()->json(['success'=>1,'data'=>$input],200,[],JSON_NUMERIC_CHECK);
        $result = new TransactionInfo();
        $result->transaction_type_id = $input->transaction_id;
        $result->employee_id = $input->employee_id;
        $result->person_id = $input->person_id;
        $result->amount = $input->amount;
        $result->transaction_date = $input->received_date;
        $result->save();

        return  response()->json(['success'=>1,'data'=>$result],200,[],JSON_NUMERIC_CHECK);


    }

    public function getEmployees()
    {
        $data = User::select()
                ->where('person_type_id',2)
                ->orWhere('person_type_id',3)
                ->orWhere('person_type_id',4)
                ->orWhere('person_type_id',5)
                ->orWhere('person_type_id',6)
                ->get();
        return  response()->json(['success'=>1,'data'=>$data],200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Model\TransactionInfo  $transactionInfo
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionInfo $transactionInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\TransactionInfo  $transactionInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionInfo $transactionInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\TransactionInfo  $transactionInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionInfo $transactionInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\TransactionInfo  $transactionInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionInfo $transactionInfo)
    {
        //
    }
}
