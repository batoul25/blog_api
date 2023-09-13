<?php
namespace App\Helpers;

use App\Models\Post;
use Illuminate\Support\Str;


if(! function_exists('PostImagePath'))
{
    function PostImagePath($image_name)
    {

         return public_path('public/images'.$image_name);

    }


}

if(! function_exists('generateSlug')){
    function generateSlug($title)
{
    // Convert the title to a slug
    $slug = Str::slug($title);

    // Check if the slug already exists in the database
    $existingSlug = Post::where('slug', $slug)->exists();

    // If the slug is already taken, append a number to make it unique
    $counter = 1;
    while ($existingSlug) {
        $slug = $slug . '-' . $counter;
        $counter++;

        $existingSlug = Post::where('slug', $slug)->exists();
    }

    // Return the unique slug
    return $slug;
}
}
