<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
class CommentapiController extends Controller
{
    //
    function list($id){

        $c = Comment::where('post_id','=',$id)->get();
        return response()->json($c);
    }

    function show($id){
        return response()->json(Comment::find($id));
    }

    function create(Request $r,$id){
        //validation
        $v = \Validator::make($r->all(),[
            'comment'=>'required|string'
        ]);
        if($v->fails()){

            return response()->json($v->errors());
        }
        $c= new Comment;
        $c->post_id =$id;
        $c->comment=$r->comment;
        $c->user_id = User::where('remember_token','=',$r->remember_token)->first()->id;
        $c->save();
        return response()->json('Comment Created Successfully');


    }

    function edit(Request $r,$id){

         //validation
         $v = \Validator::make($r->all(),[
            'comment'=>'required|string'
        ]);
        if($v->fails()){

            return response()->json($v->errors());
        }
        $c = Comment::find($id);
        $c->comment = $r->comment;
        $c->update();
        return response()->json($c);
    }

    function destroy($id){
        $c = Comment::find($id)->delete();
        return response()->json('Comment Deleted Successfully');
    }
}
