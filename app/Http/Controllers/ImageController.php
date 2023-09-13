<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Traits\StoreImageTarit;


use Illuminate\Support\Facades\Storage;

use function App\Helpers\PostImagePath;

class ImageController extends ApiController
{
    use StoreImageTarit;
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
     * @param  \App\Http\Requests\ImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        //
        $images = $request->file('filename');
        $path = PostImagePath($images); // Specify the directory where you want to store the images

        $storedImages = $this->storeImages($request,$images, $path);

        // Process the stored images as needed
        return $this->successResponse(new ImageResource($storedImages) , 'Image Uploded Successfuly' , 200);

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
     * @param  \App\Http\Requests\ImageRequest   $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(ImageRequest $request, Image $image)
    {
        //

        if($image) {
            $oldImage= $image->fileName;

            $name = time().'.'.$request->fileName->getClientOriginalExtension();
            $path =PostImagePath($name);
            $newImage = $this->verifyAndStoreImage($request , $name , $path);
            //delete the old photo
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



