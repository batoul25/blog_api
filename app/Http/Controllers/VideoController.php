<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoRequest;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $videos = VideoResource::collection(Video::get());
        return $this->successResponse($videos);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request)
    {
        //
        $video = new Video();
        $video -> title = $request -> title;
        $video -> url   = $request -> url;

        return (new VideoResource($video)) -> store ($request);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $video = Video::with('comments')->find($id);
        if($video){
            $comments = $video -> commnets;
            return $this->successResponse([new VideoResource($video) , compact($comments)]);
        }
        return $this->errorResponse('The Video is not found' , 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(VideoRequest $request, Video $video)
    {
        //
        if($video){
            $video -> title = $request -> title;
            $video -> url   = $request -> url;
            $video -> save();
            return $this->successResponse(new VideoResource($video) , 'The Video updated succsefully' , 201);
        }

        return $this->errorResponse('The Video is not found' , 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        //
        if($video){
            $video->comments()->delete();
            $video -> delete();
            return $this->successResponse(null , 'The Video deleted succsfully' , 200);
        }
        return $this->errorResponse('The video is not found' , 404);
    }
}
