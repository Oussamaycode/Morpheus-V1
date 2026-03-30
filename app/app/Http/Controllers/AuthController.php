<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{  

    public function register(Request $request){
        $data=$request->validate([
            'name'=>['required','string'],
            'email'=>['required','string'],
            'password'=>['required','string','confirmed']
        ]);

        if(User::count()==0){
          $user=User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'role'=>'admin']);
        }
        else{
          $user=User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'role'=>'member']);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json(['user'=>$user,'token'=>$token],201);

    }

    public function login(Request $request) {
   
    $fields = $request->validate([
        'email' => 'required|string',
        'password' => 'required|string'
    ]);

    
    $user = User::where('email', $fields['email'])->first();

    if (!$user || !Hash::check($fields['password'], $user->password)) {
        return response(['message' => 'Invalid credentials'], 401);
    }


       $token = $user->createToken('myapptoken')->plainTextToken;

      return response()->json(['user' => $user, 'token' => $token], 200);
    
    }


}
