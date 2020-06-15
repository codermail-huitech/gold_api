<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\PersonType;
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

    public function getAgent()
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
            'pin')->where('person_type_id','=',7);

        //to bind the parameters, the above statement does not bind the parameters so we need to bind them
        // using following statement
        $finalQuery=Str::replaceArray('?', $query->getBindings(), $query->toSql());

        $result=DB::table(DB::raw("($finalQuery) as table1"))->select()->get();

        return response()->json(['success'=>1,'data'=>$result], 200,[],JSON_NUMERIC_CHECK);
    }

    public function saveCustomer(Request $request)
    {
//        return $request;

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
            return response()->json(['success'=>0,'data'=>'Not Deleted'], 200,[],JSON_NUMERIC_CHECK);
        }
    }
}
