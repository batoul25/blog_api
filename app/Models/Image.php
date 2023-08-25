<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['post_id' , 'filename'];

    public function posts(){
        return $this->belongsTo(Post::class , 'post_id' ,'id');
    }

   
}
