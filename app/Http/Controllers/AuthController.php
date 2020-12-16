<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
             'email'    => $request->email,
             'password' => $request->password,
             'name' => $request->name,

         ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }
    // https://jwt-auth.readthedocs.io/en/develop/auth-guard/
    public function login(Request $request)
    {

        //$credentials = request(['email', 'password']);
        $credentials['email']=$request->email;
        $credentials['password']=$request->password;

        $user = User::where('email', '=', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['success'=>false, 'message' => 'Login Fail, pls check password']);
        }


        // Get the token
        $token = auth()->login($user);
        $tokenObject = $this->respondWithToken($token);
        $tempUser = array('id'=>$user->id,'person_name'=>$user->person_name,'person_type_id'=>$user->person_type_id);

        return response()->json(['token'=>$tokenObject,'user'=>$tempUser], 200);


        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $currentUser = Auth::user();
        $tokenObject = $this->respondWithToken($token);
        return response()->json(['user' => $currentUser, 'token'=>$tokenObject], 200);

    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
