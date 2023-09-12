<?php
namespace App\Traits;

use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Support\Str;


trait StoreImageTarit{
public function verifyAndStoreImage( ImageRequest $request, $name = 'image', $path = 'unknown'){
    if($request->hasFile('fileName'))  {

        if (!$request->file($name)->isValid()) {

            return $this->errorResponse('invalid_file_format', 422);

        }
        foreach($request->fileName as $mediaFiles) {

            //store image file into directory and db
            $imageName = Str::random(40) . '.' . $mediaFiles->getClientOriginalExtension();
            $imagePath = $mediaFiles->storeAs($path, $imageName, 'public');

             // Save the post ID along with the image
            $imageModel = new Image();
            $imageModel->filename = $imageName;
            $imageModel->path = $imagePath;
            $imageModel->post_id =$request->post_id;

            $imageModel->save();
            return $imagePath;

        }
    }
    return $this->errorResponse('upload_file_not_found', 400);
}


public function storeImages(ImageRequest $request,$images, $path)
{
    $storedImages = [];

    foreach ($images as $image) {
        $storedImages[] = $this->verifyAndStoreImage($request,$image, $path);
    }

    return $storedImages;
}


    }



