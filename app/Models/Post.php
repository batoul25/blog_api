<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id' , 'category_id' , 'title' , 'content'];
    public function categories(){
        return $this->belongsTo(Category::class , 'category_id' , 'id');
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function users(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class ,'post_tag' ,'post_id' , 'tag_id');
    }
}