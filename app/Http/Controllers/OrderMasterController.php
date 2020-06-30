<?php

namespace App\Http\Controllers;

use App\Model\CustomVoucher;
use App\Model\OrderDetail;
use App\Model\OrderMaster;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\OrderDetailController;

class OrderMasterController extends Controller
{
    public function index()
    {
        $data=OrderMaster::select('order_masters.id','order_masters.person_id','order_masters.date_of_order','order_masters.date_of_delivery','order_masters.order_number',DB::raw('customer.person_name as customer_name'),DB::raw('customer.id as customer_id'),DB::raw('agent.id as agent_id'),DB::raw('agent.person_name as agent_name'))
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
            // $voucherNumber=$customVoucher->prefix
            //     .$customVoucher->delimiter
            //     .str_pad($customVoucher->last_counter,6,'0',STR_PAD_LEFT)
            //     .$customVoucher->delimiter
            //     .$customVoucher->accounting_year;
            // $orderMaster->order_number=$voucherNumber;
            // $orderMaster->agent_id=$inputOrderMaster->agent_id;
            // $orderMaster->person_id=$inputOrderMaster->customer_id;
            // $orderMaster->employee_id=$inputOrderMaster->employee_id;
            // $orderMaster->date_of_order=$inputOrderMaster->order_date;
            // $orderMaster->date_of_delivery=$inputOrderMaster->delivery_date;
            // $orderMaster->save();


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


        $data=User::select('person_name')->where('id',$inputOrderMaster->customer_id)->get();
        $orderMaster->customer_name = $data[0]->person_name;

        $data=User::select('person_name')->where('id',$inputOrderMaster->agent_id)->get();
        $orderMaster->agent_name = $data[0]->person_name;





            //Saving Order Details
            foreach ($inputOrderDetails as $row){
                $orderDetails=new OrderDetail();
                $orderDetails->order_master_id=$orderMaster->id;
                $orderDetails->approx_gold=$row['approx_gold'];
                $orderDetails->quantity=$row['quantity'];
                $orderDetails->p_loss=$row['p_loss'];
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
        // return response()->json(['success'=>1,'data'=>$customVoucher], 200);
        return response()->json(['success'=>1,'data'=> $orderMaster], 200);
    }

    public function updateOrder(Request $request)
    {
        $input=($request->json()->all());
        $inputOrderMaster=(object)($input['master']);
        $inputOrderDetails=(object)($input['details']);
//        $inputOrderDetails = $inputOrderDetails->first->approx_gold();

//        return response()->json(['success'=>1,'data2'=>$inputOrderDetails], 200);
        $orderMaster= new OrderMaster();
        $orderMaster=OrderMaster::find($inputOrderMaster->id);
        $orderMaster->agent_id=$inputOrderMaster->agent_id;
        $orderMaster->person_id=$inputOrderMaster->customer_id;
        $orderMaster->employee_id=$inputOrderMaster->employee_id;
        $orderMaster->date_of_order=$inputOrderMaster->order_date;
        $orderMaster->date_of_delivery=$inputOrderMaster->delivery_date;
        $orderMaster->update();

        if($inputOrderDetails->id==null){
            $orderDetails=new OrderDetail();
            $orderDetails->approx_gold=$inputOrderDetails->approx_gold;
            $orderDetails->order_master_id=$orderMaster->id;
            $orderDetails->quantity=$inputOrderDetails->quantity;
            $orderDetails->p_loss=$inputOrderDetails->p_loss;
            $orderDetails->price=$inputOrderDetails->price;
            $orderDetails->product_id=$inputOrderDetails->product_id;
            $orderDetails->size=$inputOrderDetails->size;
            $orderDetails->material_id=$inputOrderDetails->material_id;
            $orderDetails->save();
        }else{
            $orderDetails=new OrderDetail();
            $orderDetails=OrderDetail::find($inputOrderDetails->id);
            $orderDetails->approx_gold=$inputOrderDetails->approx_gold;
            $orderDetails->quantity=$inputOrderDetails->quantity;
            $orderDetails->p_loss=$inputOrderDetails->p_loss;
            $orderDetails->price=$inputOrderDetails->price;
            $orderDetails->product_id=$inputOrderDetails->product_id;
            $orderDetails->size=$inputOrderDetails->size;
            $orderDetails->material_id=$inputOrderDetails->material_id;
            $orderDetails->update();
        }

        $orderDetails->amount=$inputOrderDetails->price * $inputOrderDetails->quantity;
        $orderDetails->model_number=$inputOrderDetails->model_number;
        $orderDetails->price_code=$inputOrderDetails->price_code;

        $data=User::select('person_name')->where('id',$inputOrderMaster->customer_id)->get();
        $orderMaster->customer_name = $data[0]->person_name;

        $data=User::select('person_name')->where('id',$inputOrderMaster->agent_id)->get();
        $orderMaster->agent_name = $data[0]->person_name;

        return response()->json(['success'=>1, 'orderDetail'=>$orderDetails, 'orderMaster'=>$orderMaster], 200);
    }

    public function deleteOrderMaster($id)
    {
        $detailsDelete = OrderDetail::where('order_master_id',$id)->delete();
        $orderMaster= new OrderMaster();
        $orderMaster=OrderMaster::find($id);
        $orderMaster->delete();
        $success=0;
        if($orderMaster){
            $success=1;
        }
        return response()->json(['success'=>$success, 'data'=>$orderMaster], 200);
    }

    public function updateMaster(Request $request)
    {
        $input=($request->json()->all());
        $inputOrderMaster=(object)($input['master']);
        $orderMaster= new OrderMaster();
        $orderMaster=OrderMaster::find($inputOrderMaster->id);
        $orderMaster->agent_id=$inputOrderMaster->agent_id;
        $orderMaster->person_id=$inputOrderMaster->customer_id;
        $orderMaster->employee_id=$inputOrderMaster->employee_id;
        $orderMaster->date_of_order=$inputOrderMaster->order_date;
        $orderMaster->date_of_delivery=$inputOrderMaster->delivery_date;
        $orderMaster->update();
        $data=User::select('person_name')->where('id',$inputOrderMaster->customer_id)->get();
        $orderMaster->customer_name = $data[0]->person_name;
        $data=User::select('person_name')->where('id',$inputOrderMaster->agent_id)->get();
        $orderMaster->agent_name = $data[0]->person_name;
        return response()->json(['success'=>1, 'data'=>$orderMaster], 200);
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
