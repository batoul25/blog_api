<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class PostEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch($this->method())
        {
            case 'DELETE':
            case 'PATCH':
            case 'PUT':
            {
                // where 'posts' is the placeholder for the post id of the route
                $post = Post::find($this->posts);
                
                return $post->user_id == $this->user()->id;
            }
            case 'GET':
            case 'POST':
            {
                return true;
            }
            default:
            {
                break;
            }
        }
        return false;
    }
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
