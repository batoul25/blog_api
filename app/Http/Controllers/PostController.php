<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResourse;
use Illuminate\Support\Facades\Auth;

class PostController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();
        return $this->successResponse('success' , '' ,$posts);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //
        $categoryId = Category::where('name' , $request->category)->findorFail()->id;

        $tagId = Tag::where('name' , $request->tag)->findOrFail()->id;
        $post = new Post();
        $post->title = $request->title;
        $post->content =$request->content;
        $post->categories()->attach([$categoryId]);
        $post->tags()->attach([$tagId]);

        
       
         return (new PostResourse($post))->store($request);
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        if($post) {
            return $this->successResponse(new PostResourse($post), '', 200);
        }
        return $this->errorResponse('The post is not found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        //
        if($post) {
            $post = new Post();
            $post->title = $request->title;
            $post->content =$request->content;
            $post->user_id = Auth::user()->id;
            $post->category_id = $request->category_id;
            $post->save();
            return $this->successResponse(new PostResourse($post), 'The post updated successfuly', 201);
        }
        return $this->errorResponse('The post is not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        if($post){
            $post->delete();
            return $this->successResponse(null , 'The post was deleted successfuly' , 201);
        }
        return $this->errorResponse('The post is not found' , 404);
    }
}
