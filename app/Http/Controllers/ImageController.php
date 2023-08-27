<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;




class ImageController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $images =  ImageResource::collection(Image::get());;
        return $this->successResponse($images);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        //
        if(!$request->hasFile('fileName')) {
            return $this->errorResponse('upload_file_not_found', 400);
        }
    
        $allowedfileExtension=['pdf','jpg','png'];
        $files = $request->file('fileName'); 
        $errors = [];
    
        foreach ($files as $file) {      
    
            $extension = $file->getClientOriginalExtension();
    
            $check = in_array($extension,$allowedfileExtension);
    
            if($check) {
                foreach($request->fileName as $mediaFiles) {
    
                    $path = $mediaFiles->store('public/images');
                    $name = $mediaFiles->getClientOriginalName();
         
                    //store image file into directory and db
                    $save = new Image();
                    $save->filename = $name;
                    $save->path = $path;
                    $save->post_id = $request->post_id;
                    $save->save();
                    return $this->successResponse(new ImageResource($save) , 'Image Uploded Successfuly' , 200);
    
                }
            }
        }
                return $this->errorResponse('invalid_file_format', 422);
       
            
       
        }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
        if($image){
            return $this->successResponse(new ImageResource($image));
        }
        return $this->errorResponse('The image is not found' , 404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    
        if($image) {
            $oldImage= $image->fileName;
            $newImage = $request->fileName;
            $name = time().'.'.$newImage->getClientOriginalExtension();
            $path =$newImage->store('public/images');
            $newImage->fileName =$name ;
            $newImage->path = $path;
            $newImage->post_id = $request->post_id;
            $newImage->save();
            Storage::delete('public/images/' . $oldImage);
            return $this->successResponse(new ImageResource($newImage), 'The image was updated succsfully', 201);
        }
        return $this->errorResponse('The image is not found' , 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
        if($image){
            Storage::delete('public/images/' . $image);
            return $this->successResponse(null , 'The image was deleted succsfully', 200);
        }
        return $this->errorResponse('The image is not found' , 404);
    }
}
 


