<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['title' , 'url'];


    //Get all the video's comments (one to many polymorphic relation)
    public function comments(){
        return $this->morphMany(Comment::class , 'commentable');
    }
}
