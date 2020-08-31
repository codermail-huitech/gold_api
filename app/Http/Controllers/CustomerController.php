<?php

namespace App\Http\Controllers;

use App\Model\CustomVoucher;
use App\Model\OrderDetail;
use App\Model\OrderMaster;
use App\Model\JobMaster;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
//        $customers = PersonType::find(10)->people;
        $query = User::select('id',
            'person_name',
            'person_type_id',
            'email',
            'mobile1',
            'mobile2',
            'customer_category_id',
            'address1',
            'address2',
            'state',
            'city',
            'po',
            'area',
            'pin')->where('person_type_id','=',10);

        //to bind the parameters, the above statement does not bind the parameters so we need to bind them
        // using following statement
        $finalQuery=Str::replaceArray('?', $query->getBindings(), $query->toSql());

        $result=DB::table(DB::raw("($finalQuery) as table1"))->select()->get();

        return response()->json(['success'=>1,'data'=>$result], 200,[],JSON_NUMERIC_CHECK);
    }



    public function saveCustomer(Request $request)
    {
        $customer=new User();

        $customer->person_name=$request->input('person_name');
        $customer->email=$request->input('email');
        $customer->password="81dc9bdb52d04dc20036dbd8313ed055";
        $customer->person_type_id=$request->input('person_type_id');
        $customer->customer_category_id=$request->input('customer_category_id');
        $customer->mobile1=$request->input('mobile1');
        $customer->mobile2=$request->input('mobile2');
        $customer->address1=$request->input('address1');
        $customer->address2=$request->input('address2');
        $customer->state=$request->input('state');
        $customer->po=$request->input('po');
        $customer->area=$request->input('area');
        $customer->city=$request->input('city');
        $customer->pin=$request->input('pin');

        $customer->save();
        return response()->json(['success'=>1,'data'=>$customer], 200);
    }

    public function updateCustomer($id,Request $request)
    {
        $customer=User::find($id);
        if($request->input('person_name')){
            $customer->person_name=$request->input('person_name');
        }
        if($request->input('email')){
            $customer->email=$request->input('email');
        }
        if($request->input('password')){
            $customer->password=$request->input('password');
        }

        if($request->input('person_type_id')){
            $customer->person_type_id=$request->input('person_type_id');
        }

        if($request->input('customer_category_id')){
            $customer->customer_category_id=$request->input('customer_category_id');
        }

        if($request->input('mobile1')){
            $customer->mobile1=$request->input('mobile1');
        }

        if($request->input('mobile2')){
            $customer->mobile2=$request->input('mobile2');
        }

        if($request->input('address1')){
            $customer->address1=$request->input('address1');
        }

        if($request->input('address2')){
            $customer->address2=$request->input('address2');
        }

        if($request->input('state')){
            $customer->state=$request->input('state');
        }

        if($request->input('po')){
            $customer->po=$request->input('po');
        }

        if($request->input('area')){
            $customer->area=$request->input('area');
        }

        if($request->input('city')){
            $customer->city=$request->input('city');
        }

        if($request->input('pin')){
            $customer->pin=$request->input('pin');
        }


        $customer->save();
        return response()->json(['success'=>1,'data'=>$customer], 200,[],JSON_NUMERIC_CHECK);
    }
    public function deleteCustomer($id)
    {
        $res = User::destroy($id);
        if ($res) {
            return response()->json(['success'=>1,'message'=>'Deleted'], 200,[],JSON_NUMERIC_CHECK);
        } else {
            return response(o)->json(['success'=>0,'data'=>'Not Deleted'], 200,[],JSON_NUMERIC_CHECK);
        }
    }
    public function getkarigarhs()
    {
        $result = User::select('id','person_name')->where('person_type_id','=',11)->get();

        return response()->json(['success'=>1,'data'=>$result], 200,[],JSON_NUMERIC_CHECK);

    }
    public function finishedJobsCustomers(){
        $result = OrderMaster::select(DB::raw('order_masters.id as order_master_id'),'users.person_name')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->where('order_details.status_id','=',100)
            ->get();
        return response()->json(['success'=>1,'data'=>$result], 200,[],JSON_NUMERIC_CHECK);
    }

    public function getDetails(Request $request){
        $input=($request->json()->all());
        $data = OrderMaster::select('order_masters.order_number','order_details.id','users.person_name')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->where('order_details.status_id','=',100)
            ->where('order_details.order_master_id','=',$input)
            ->get();
        return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);
    }

      public function getFinishedJobData(Request $request){
            $input=($request->json()->all());
            $data = JobMaster::select()
                ->join('users', 'job_masters.karigarh_id', '=', 'users.id')
                ->where('job_masters.status_id','=',100)
                ->where('job_masters.order_details_id','=',$input)
                ->get();
            return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);
        }




//    public function testFinished(){
//        $result = OrderMaster::select(DB::raw('order_masters.id as order_master_id'),DB::raw('order_details.id as order_detail_id'),'users.id','users.person_name')
//            ->join('users', 'order_masters.person_id', '=', 'users.id')
//            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
//            ->where('order_details.status_id','=',100)
//            ->get();
//        return response()->json(['success'=>1,'data'=>$result], 200,[],JSON_NUMERIC_CHECK);
//    }
}
