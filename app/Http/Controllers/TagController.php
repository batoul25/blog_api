<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tags = TagResource::collection(Tag::get());
        return $this->successResponse($tags);
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
        $tag = new Tag();
        $tag->name = $request->name;

        return (new TagResource($tag))->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
        if($tag){
            return $this->successResponse(new TagResource($tag));
        }
        return $this->errorResponse('The tag is not found' , 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
        if($tag){
            $tag = new Tag();
            $tag->name = $request->name;
            $tag->save();
            return $this->successResponse(new TagResource($tag), 'The tag was updated succesfully' , 201);
        }
        return $this->errorResponse('The tag is not found' , 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
        if($tag){
            
            return $this->successResponse(null , 'The tag was deleted successfuly', 200);
        }
        return $this->errorResponse('The tag is not found' , 404);
    }

}
