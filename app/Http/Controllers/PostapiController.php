<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
class PostapiController extends Controller
{
    //
    function list(){
        $posts = Post::get();
        return response()->json($posts);
    }

    function show($id){
        $post = Post::find($id);
        return response()->json($post->comments()->get());
    }

    function create(Request $r){

        //validation
        $v = \Validator::make($r->all(),[
            'title'=>'required|string|min:3',
            'desc'=>'required|string|min:3',
            'content'=>'required|string|min:5'
        ]);
        if($v->fails()){
            return response()->json($v->errors());
        }
        $post = new Post;
        $post->title = $r->title;
        $post->desc = $r->desc;
        $post->content = $r->content;
        $post->user_id = User::where('remember_token','=',$r->remember_token)->first()->id;
        $post->save();
        return response()->json('post Created Successfully');

    }

    function edit(Request $r, $id){
         //validation
         $v = \Validator::make($r->all(),[
            'title'=>'required|string|min:3',
            'desc'=>'required|string|min:3',
            'content'=>'required|string|min:5'
        ]);
        if($v->fails()){
            return response()->json($v->errors());
        }
        $post = Post::find($id);
        $post->title = $r->title;
        $post->desc = $r->desc;
        $post->content = $r->content;
        // $post->user_id = 1;
        $post->update();
        return response()->json('post Updated Successfully');

    }

    function destroy($id){

        Post::find($id)->delete();
        return response()->json('Post Deleted Successfully');
    }
}
