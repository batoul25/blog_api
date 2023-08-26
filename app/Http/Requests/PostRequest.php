<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rule_title_unique = Rule::unique('posts', 'name');
        if ($this->method() !== 'POST') {
            $rule_title_unique->ignore($this->post->id);
        }

        return [
            'title' => ['required', $rule_title_unique, 'max:255'],
            'content' => ['required'],
        ];
    }
}
