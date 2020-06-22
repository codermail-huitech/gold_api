<?php

namespace App\Http\Controllers;

use App\Model\CustomVoucher;
use App\Model\OrderDetail;
use App\Model\OrderMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\OrderDetailController;

class OrderMasterController extends Controller
{
    public function index()
    {
        $data=OrderMaster::select('order_masters.person_id','order_masters.date_of_order','order_masters.date_of_delivery','order_masters.order_number',DB::raw('customer.person_name as customer_name'),DB::raw('agent.person_name as agent_name'))
            ->join('users as customer', 'customer.id', '=', 'order_masters.person_id')
            ->join('users as agent', 'agent.id', '=', 'order_masters.agent_id')
            ->get();
        return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);
    }

    public function saveOrder(Request $request){

        $input=($request->json()->all());

//        return response()->json(['Success'=>1,'data'=>$input], 200);


        $inputOrderMaster=(object)($input['master']);
        $inputOrderDetails=($input['details']);

        DB::beginTransaction();
        $customVoucher=CustomVoucher::where('voucher_name',"order")->Where('accounting_year',"2020")->first();

        if($customVoucher) {
            $customVoucher->last_counter = $customVoucher->last_counter + 1;
            $customVoucher->save();
        }else{
            $customVoucher= new CustomVoucher();
            $customVoucher->voucher_name="order";
//            $customVoucher->accounting_year=$inputOrderMaster->accounting_year;
            $customVoucher->accounting_year="2020";
            $customVoucher->last_counter=1;
            $customVoucher->delimiter='/';
            $customVoucher->prefix='ORD';
            $customVoucher->save();
        }
        try
        {
            //Saving Order Master
            $orderMaster= new OrderMaster();
            $voucherNumber=$customVoucher->prefix
                .$customVoucher->delimiter
                .str_pad($customVoucher->last_counter,6,'0',STR_PAD_LEFT)
                .$customVoucher->delimiter
                .$customVoucher->accounting_year;
            $orderMaster->order_number=$voucherNumber;
            $orderMaster->agent_id=$inputOrderMaster->agent_id;
            $orderMaster->person_id=$inputOrderMaster->customer_id;
            $orderMaster->employee_id=$inputOrderMaster->employee_id;
            $orderMaster->date_of_order=$inputOrderMaster->order_date;
            $orderMaster->date_of_delivery=$inputOrderMaster->delivery_date;
            $orderMaster->save();

            //Saving Order Details
            foreach ($inputOrderDetails as $row){
                $orderDetails=new OrderDetail();
                $orderDetails->order_master_id=$orderMaster->id;
                $orderDetails->approx_gold=$row['approx_gold'];
                $orderDetails->quantity=$row['quantity'];
                $orderDetails->p_loss=$row['pLoss'];
                $orderDetails->price=$row['price'];
                $orderDetails->product_id=$row['product_id'];
                $orderDetails->size=$row['size'];
                $orderDetails->material_id=$row['material_id'];
                $orderDetails->save();
            }
            DB::commit();
        }

        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['Success'=>1,'Exception'=>$e], 401);
        }
        return response()->json(['success'=>1,'data'=>$customVoucher], 200);
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
     * @param  \App\Model\OrderMaster  $orderMaster
     * @return \Illuminate\Http\Response
     */
    public function show(OrderMaster $orderMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\OrderMaster  $orderMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderMaster $orderMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\OrderMaster  $orderMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderMaster $orderMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\OrderMaster  $orderMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderMaster $orderMaster)
    {
        //
    }
}
