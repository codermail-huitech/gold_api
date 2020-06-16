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
}
