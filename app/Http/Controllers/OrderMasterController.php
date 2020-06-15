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
        $data=OrderMaster::select()
            ->join('price_codes', 'price_codes.id', '=', 'products.price_code_id')
            ->get();
        return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);
    }

    public function saveOrder(Request $request){
        $input=($request->json()->all());

        $inputOrderMaster=(object)($input['orderMaster']);
        $inputOrderDetails=($input['orderDetails']);

        DB::beginTransaction();
        $customVoucher=CustomVoucher::where('voucher_name',$inputOrderMaster->voucher_name)->Where('accounting_year',$inputOrderMaster->accounting_year)->first();

        if($customVoucher) {
            $customVoucher->last_counter = $customVoucher->last_counter + 1;
            $customVoucher->save();
        }else{
            $customVoucher= new CustomVoucher();
            $customVoucher->voucher_name=$inputOrderMaster->voucher_name;
            $customVoucher->accounting_year=$inputOrderMaster->accounting_year;
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
            $orderMaster->person_id=$inputOrderMaster->person_id;
            $orderMaster->employee_id=$inputOrderMaster->employee_id;
            $orderMaster->date_of_order=$inputOrderMaster->date_of_order;
            $orderMaster->date_of_delivery=$inputOrderMaster->date_of_delivery;
            $orderMaster->save();

            //Saving Order Details
            foreach ($inputOrderDetails as $row){
                $orderDetails=new OrderDetail();
                $orderDetails->order_master_id=$orderMaster->id;
                $orderDetails->approx_gold=$row['approxGold'];
                $orderDetails->quantity=$row['quantity'];
                $orderDetails->p_loss=$row['pLoss'];
                $orderDetails->price=$row['price'];
                $orderDetails->product_id=$row['model_id'];
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
        return response()->json(['Success'=>1,'product'=>$customVoucher], 200);
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
