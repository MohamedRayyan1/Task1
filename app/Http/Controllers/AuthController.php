<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',

            'email' => 'required|email',
            'password' => 'required|min:8|max:12',
      ]);

          $user = User::create([
              'password' => bcrypt($validate['password']),
              'email' => $validate['email'],
              'name' => $validate['name'],

          ]);

         $token =JWTAuth::fromUser($user);
        //  dd($token);
          $access['email'] = $user->email; //
          $access['token'] = $token; //
          return response()->json($access,200);

          return response()->json(['message error'=>'some things went wrong']);
    }

    public function login(Request $request)
    {


          $credentials = ['email'=>$request->email,'password'=>$request->password];
            if(auth()->attempt($credentials )){
                $user = auth()->user();
                $token =JWTAuth::fromUser($user);
                $access['id'] =   $user->id;

                $access['name'] = $user->name; //


                return response()->json([
                    'message'=>'login successfully',
                    'token'=> $token,
                   
                    'user_id'=>$user->id ,
                    'name'=> $access['name'],


                ]);

            }

            return response()->json('the user is not exists!');
    }
}
