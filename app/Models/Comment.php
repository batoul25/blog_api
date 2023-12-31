<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['body' , 'commentable_id' , 'commentable_type'];

    //Get The parent commentable model (post or video)
    public function commentable(){
        return $this->morphTo();
    }

    //comments belongs to user
    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
