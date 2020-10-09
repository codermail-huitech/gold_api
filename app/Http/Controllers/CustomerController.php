<?php

namespace App\Http\Controllers;

use App\Model\BillDetail;
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
            'pin')->where('person_type_id', '=', 10);

        //to bind the parameters, the above statement does not bind the parameters so we need to bind them
        // using following statement
        $finalQuery = Str::replaceArray('?', $query->getBindings(), $query->toSql());

        $result = DB::table(DB::raw("($finalQuery) as table1"))->select()->get();

        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
    }


    public function saveCustomer(Request $request)
    {
        $customer = new User();

        $customer->person_name = $request->input('person_name');
        $customer->email = $request->input('email');
        $customer->password = "81dc9bdb52d04dc20036dbd8313ed055";
        $customer->person_type_id = $request->input('person_type_id');
        $customer->customer_category_id = $request->input('customer_category_id');
        $customer->mobile1 = $request->input('mobile1');
        $customer->mobile2 = $request->input('mobile2');
        $customer->address1 = $request->input('address1');
        $customer->address2 = $request->input('address2');
        $customer->state = $request->input('state');
        $customer->po = $request->input('po');
        $customer->area = $request->input('area');
        $customer->city = $request->input('city');
        $customer->pin = $request->input('pin');
        $customer->opening_balance_LC = $request->input('opening_balance_LC');
        $customer->opening_balance_Gold = $request->input('opening_balance_Gold');

        $customer->save();
        return response()->json(['success' => 1, 'data' => $customer], 200);
    }

    public function updateCustomer($id, Request $request)
    {
        $customer = User::find($id);
        if ($request->input('person_name')) {
            $customer->person_name = $request->input('person_name');
        }
        if ($request->input('email')) {
            $customer->email = $request->input('email');
        }
        if ($request->input('password')) {
            $customer->password = $request->input('password');
        }

        if ($request->input('person_type_id')) {
            $customer->person_type_id = $request->input('person_type_id');
        }

        if ($request->input('customer_category_id')) {
            $customer->customer_category_id = $request->input('customer_category_id');
        }

        if ($request->input('mobile1')) {
            $customer->mobile1 = $request->input('mobile1');
        }

        if ($request->input('mobile2')) {
            $customer->mobile2 = $request->input('mobile2');
        }

        if ($request->input('address1')) {
            $customer->address1 = $request->input('address1');
        }

        if ($request->input('address2')) {
            $customer->address2 = $request->input('address2');
        }

        if ($request->input('state')) {
            $customer->state = $request->input('state');
        }

        if ($request->input('po')) {
            $customer->po = $request->input('po');
        }

        if ($request->input('area')) {
            $customer->area = $request->input('area');
        }

        if ($request->input('city')) {
            $customer->city = $request->input('city');
        }

        if ($request->input('pin')) {
            $customer->pin = $request->input('pin');
        }


        $customer->save();
        return response()->json(['success' => 1, 'data' => $customer], 200, [], JSON_NUMERIC_CHECK);
    }

    public function deleteCustomer($id)
    {
        $res = User::destroy($id);
        if ($res) {
            return response()->json(['success' => 1, 'message' => 'Deleted'], 200, [], JSON_NUMERIC_CHECK);
        } else {
            return response(o)->json(['success' => 0, 'data' => 'Not Deleted'], 200, [], JSON_NUMERIC_CHECK);
        }
    }

    public function getkarigarhs()
    {
        $result = User::select('id', 'person_name')->where('person_type_id', '=', 11)->get();

        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);

    }

    public function getGoldquantity()
    {
        $result = OrderMaster::select('users.person_name', 'users.id')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->where('order_details.bill_created','=',0)
            ->where('order_details.status_id','=',100)
            ->distinct()
            ->get();
        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getDetails(Request $request)
    {
        $input = ($request->json()->all());
        $data = OrderMaster::select(DB::raw(" distinct order_masters.order_number"), 'order_masters.id', 'users.person_name')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->join('job_masters', 'job_masters.order_details_id', '=', 'order_details.id')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->where('order_details.bill_created','=',0)
            ->where('order_masters.person_id', '=', $input)
            ->get();
        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getCompletedBIllDetails(Request $request)
    {
        $input = ($request->json()->all());
        $data = OrderMaster::select(DB::raw(" distinct order_masters.order_number"), 'order_masters.id', 'users.person_name')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->join('job_masters', 'job_masters.order_details_id', '=', 'order_details.id')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->where('order_details.bill_created','=',1)
            ->where('order_masters.person_id', '=', $input)
            ->get();
        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getFinishedJobData(Request $request)
    {
        $input = ($request->json()->all());
        $data = JobMaster::select(DB::raw('order_masters.id as order_master_id'), DB::raw('karigarh.person_name as karigarh_name'), DB::raw('users.id as customer_id'), DB::raw('karigarh.id as karigarh_id'), 'order_masters.order_number', 'order_masters.date_of_order', 'job_masters.gross_weight', 'products.model_number', 'order_details.size', 'order_details.quantity', 'order_details.price','order_masters.date_of_order', 'job_masters.job_number', 'users.person_name', 'users.address1', 'users.mobile1', 'users.state', 'users.po', 'users.area', 'users.city', 'users.pin', 'job_masters.id', DB::raw("if(order_details.status_id = 100,'COMPLETED',if(order_details.status_id = 40,'NOT STARTED','WORK IN PROGRESS')) as status"))
            ->join('users as karigarh', 'job_masters.karigarh_id', '=', 'karigarh.id')
            ->join('order_details', 'job_masters.order_details_id', '=', 'order_details.id')
            ->join('order_masters', 'order_details.order_master_id', '=', 'order_masters.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->where('job_masters.bill_created','=',0)
            ->where('order_masters.id', '=', $input)
            ->get();
        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

    public function showCompletedBills(Request $request)
    {
        $input = ($request->json()->all());
//        $data = JobMaster::select('bill_masters.bill_number','bill_masters.bill_date',DB::raw('order_masters.id as order_master_id'), DB::raw('karigarh.person_name as karigarh_name'), DB::raw('users.id as customer_id'), DB::raw('karigarh.id as karigarh_id'), 'order_masters.order_number', 'order_masters.date_of_order', 'job_masters.gross_weight', 'products.model_number', 'order_details.size', 'order_details.quantity', 'order_details.price','order_masters.date_of_order', 'job_masters.job_number', 'users.person_name', 'users.address1', 'users.mobile1', 'users.state', 'users.po', 'users.area', 'users.city', 'users.pin', 'job_masters.id', DB::raw("if(order_details.status_id = 100,'COMPLETED',if(order_details.status_id = 40,'NOT STARTED','WORK IN PROGRESS')) as status"))
//            ->join('users as karigarh', 'job_masters.karigarh_id', '=', 'karigarh.id')
//            ->join('order_details', 'job_masters.order_details_id', '=', 'order_details.id')
//            ->join('order_masters', 'order_details.order_master_id', '=', 'order_masters.id')
//            ->join('bill_masters', 'bill_masters.order_master_id', '=', 'order_masters.id')
//            ->join('products', 'order_details.product_id', '=', 'products.id')
//            ->join('users', 'order_masters.person_id', '=', 'users.id')
////            ->join('bill_details', 'bill_details.bill_master_id', '=', 'bill_masters.id')
//            ->where('job_masters.bill_created','=',1)
//            ->where('bill_masters.id', '=', 1)
////            ->where('bill_details.bill_master_id', '=', 1)
//            ->get();



//        $data = BillDetail::select('bill_masters.bill_number','bill_masters.bill_date',DB::raw('order_masters.id as order_master_id'), DB::raw('karigarh.person_name as karigarh_name'), DB::raw('users.id as customer_id'), DB::raw('karigarh.id as karigarh_id'), 'order_masters.order_number', 'order_masters.date_of_order', 'job_masters.gross_weight', 'products.model_number', 'order_details.size', 'order_details.quantity', 'order_details.price','order_masters.date_of_order', 'job_masters.job_number', 'users.person_name', 'users.address1', 'users.mobile1', 'users.state', 'users.po', 'users.area', 'users.city', 'users.pin', 'job_masters.id', DB::raw("if(order_details.status_id = 100,'COMPLETED',if(order_details.status_id = 40,'NOT STARTED','WORK IN PROGRESS')) as status"))
        $data = BillDetail::select()
            ->join('bill_masters', 'bill_masters.id', '=', 'bill_details.bill_master_id')
            ->join('job_masters', 'job_masters.id', '=', 'bill_details.job_master_id')
            ->join('users as karigarh', 'job_masters.karigarh_id', '=', 'karigarh.id')
            ->join('order_details', 'order_details.id', '=', 'job_masters.order_details_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('order_masters', 'order_masters.id', '=', 'order_details.order_master_id')
            ->join('users', 'users.id', '=', 'order_masters.person_id')

            ->where('bill_masters.id', '=', 1)
//            ->where('bill_details.bill_master_id', '=', 1)
            ->get();





        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }



    public function getFinishedBillData(Request $request)
    {
        $input = ($request->json()->all());


//        $data = JobMaster::select(DB::raw('order_masters.id as order_master_id'),  DB::raw('users.id as customer_id'), DB::raw('karigarh.id as karigarh_id'), 'bill_masters.bill_number','order_masters.order_number', 'order_masters.date_of_order', 'job_masters.gross_weight', 'products.model_number', 'order_details.size', 'order_details.quantity', 'order_details.price','order_masters.date_of_order', 'job_masters.job_number', 'users.person_name', 'users.address1', 'users.mobile1', 'users.state', 'users.po', 'users.area', 'users.city', 'users.pin', DB::raw("if(order_details.status_id = 100,'COMPLETED',if(order_details.status_id = 40,'NOT STARTED','WORK IN PROGRESS')) as status"))
         $data = JobMaster::select('bill_masters.bill_number','bill_masters.id')
            ->join('users as karigarh', 'job_masters.karigarh_id', '=', 'karigarh.id')
            ->join('order_details', 'job_masters.order_details_id', '=', 'order_details.id')
            ->join('order_masters', 'order_details.order_master_id', '=', 'order_masters.id')
            ->join('bill_masters', 'bill_masters.order_master_id', '=', 'order_masters.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->where('job_masters.bill_created','=',1)
            ->where('order_masters.id', '=', $input)
            ->distinct()
            ->get();
        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getGoldQuantityBill($id){

//        $input = ($request->json()->all());

        $result=DB::query()->fromSub(function ($query) use($id){
            $query->from("job_details")
                ->select(DB::raw("SUM(if(material_quantity>0,material_quantity,0)) as positive_value, SUM(if(material_quantity<0,material_quantity,0)) as negative_value"))
                ->where("job_details.job_task_id",1)
                ->where("job_details.job_master_id",$id)
                ->orWhere("job_details.job_task_id",2)
                ->where("job_details.job_master_id",$id);
        },"table1")->select("table1.positive_value","table1.negative_value",DB::raw("abs(table1.positive_value + table1.negative_value) as total"))
            ->get();

        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);

    }

    public function finishedJobsCustomers()
    {
        $result = OrderMaster::select('users.person_name', 'users.id')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->where('order_details.bill_created','=',0)
            ->where('order_details.status_id','=',100)
            ->distinct()
            ->get();
        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
    }

    public function completedBillCustomers()
    {
        $result = OrderMaster::select('users.person_name', 'users.id')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->join('bill_masters', 'bill_masters.order_master_id', '=', 'order_masters.id')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->where('order_details.bill_created','=',1)
            ->where('order_details.status_id','=',100)
            ->distinct()
            ->get();
        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
    }


}
