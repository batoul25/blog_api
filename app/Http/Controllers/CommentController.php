<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Http\Request;

class CommentController extends ApiController
{
    public function __construct(){
        $this->middleware('auth')->only('update' , 'destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $commentableType = $request->input('commentable_type');
        $commentableId   = $request->input('commentable_id');

        if($commentableType === 'post'){
            $commentable = Post::find($commentableId);
        }
        elseif($commentableType === 'video'){
            $commentable = Video::find($commentableId);
        }

        if($commentable){
            $comments = $commentable -> comments;
            return $this->successResponse($comments);
        }
        else{
            return $this->errorResponse('There is no comments' , 404);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $commentableType = $request->input('commentable_type');
        $commentableId   = $request->input('commentable_id');

        if($commentableType === 'post'){
            $commentable = Post::find($commentableId);
        }
        elseif($commentableType === 'video'){
            $commentable = Video::find($commentableId);
        }
        if($commentable){
            $comment = new Comment();
            $comment -> body = $request->input('body');
            $comment -> user_id = auth()->user()->id;
            $commentable -> comments() -> save($comment);
            return $this->successResponse(new CommentResource($comment));
        }
        else{
            return $this->errorResponse('The Comment is not found' , 404);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
        if($comment){
            return $this->successResponse(new CommentResource($comment));
        }
            return $this->errorResponse('The comment is not found' , 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
        if($comment){
            $comment -> body = $request -> body;
            $comment -> save();
            return $this->successResponse(new CommentResource($comment), 'The Comment updated sucssufully' , 201);
        }
        return $this->errorResponse('The comment is not found' , 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
        if($comment){
            $comment -> delete();
            return $this->successResponse(null , 'The Comment deleted sucsfully' , 200);
        }
        return $this->errorResponse('The Comment is not found' , 404);
    }
}
