<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Model\PersonType;

class AgentController extends Controller
{
    public function index()
    {
        $agents = PersonType::find(7)->people;
        return response()->json(['success'=>1,'data'=>$agents], 200,[],JSON_NUMERIC_CHECK);
    }

    public function saveAgent(Request $request){
//        $newData = (object)($request->json()->all());
        $agent = new User();
        $agent->person_name = $request->input('person_name');
        $agent->email = $request->input('email');
        $agent->password = "81dc9bdb52d04dc20036dbd8313ed055";
        $agent->person_type_id = 7;
        $agent->customer_category_id = $request->input('customer_category_id');
        $agent->mobile1 = $request->input('mobile1');
        $agent->mobile2 = $request->input('mobile2');
        $agent->address1 = $request->input('address1');
        $agent->address2 = $request->input('address2');
        $agent->state = $request->input('state');
        $agent->po = $request->input('po');
        $agent->area = $request->input('area');
        $agent->city = $request->input('city');
        $agent->pin = $request->input('pin');
        $agent->opening_balance_LC = 0;
        $agent->opening_balance_Gold = 0;
        $agent->save();
        return response()->json(['success' => 1, 'data' => $agent], 200,[],JSON_NUMERIC_CHECK);
    }

    public function updateAgent($id,Request $request){
        $agent = User::find($id);
        if ($request->input('person_name')) {
            $agent->person_name = $request->input('person_name');
        }
        if ($request->input('email')) {
            $agent->email = $request->input('email');
        }
        if ($request->input('password')) {
            $agent->password = $request->input('password');
        }

        if ($request->input('person_type_id')) {
            $agent->person_type_id = $request->input('person_type_id');
        }

        if ($request->input('customer_category_id')) {
            $agent->customer_category_id = $request->input('customer_category_id');
        }

        if ($request->input('mobile1')) {
            $agent->mobile1 = $request->input('mobile1');
        }

        if ($request->input('mobile2')) {
            $agent->mobile2 = $request->input('mobile2');
        }

        if ($request->input('address1')) {
            $agent->address1 = $request->input('address1');
        }

        if ($request->input('address2')) {
            $agent->address2 = $request->input('address2');
        }

        if ($request->input('state')) {
            $agent->state = $request->input('state');
        }

        if ($request->input('po')) {
            $agent->po = $request->input('po');
        }

        if ($request->input('area')) {
            $agent->area = $request->input('area');
        }

        if ($request->input('city')) {
            $agent->city = $request->input('city');
        }

        if ($request->input('pin')) {
            $agent->pin = $request->input('pin');
        }
        $agent->save();
        return response()->json(['success' => 1, 'data' => $agent], 200, [], JSON_NUMERIC_CHECK);
    }

    public function deleteAgent($id){
        $data = User::find($id);
        $data->delete();
        return response()->json(['success' => 1, 'data' => $data], 200,[],JSON_NUMERIC_CHECK);
    }
}
