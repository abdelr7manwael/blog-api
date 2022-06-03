<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserapiController extends Controller
{
    //

    function list(){
        return response()->json(User::get());
    }

    function show($id){
        return response()->json(User::find($id));
    }
    function destroy($id){
        User::find($id)->delete();
        return response()->json('User Deleted Sucessfully');
    }

    function register(Request $r){
        //validation
        $v = \Validator::make($r->all(),[
            'name'=>'required|string|min:3',
            'email'=>'required|email|unique:users,email,',
            'password'=>'required|string|confirmed'

        ]);
        if($v->fails()){
            return response()->json($v->errors());
        }

        $user = new User;
        $user->name = $r->name;
        $user->email = $r->email;
        $user->password = \Hash::make($r->password);
        $user->remember_token = \Str::random(64);
        $user->save();
        return response()->json('User Created Successfully');
    }

    function login(Request $r){
         //validation
         $v = \Validator::make($r->all(),[
            'email'=>'required|email',
            'password'=>'required|string'

        ]);
        if($v->fails()){
            return response()->json($v->errors());
        }

        if(\Auth::attempt(['email' => $r->email, 'password' => $r->password])){
            return response()->json(\Auth::user()->remember_token);
        }
        return response()->json('Not Valid User');
    }
}
