<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rule_title_unique = Rule::unique('videos', 'title');
        if ($this->method() !== 'POST') {
            $rule_title_unique->ignore($this->video->id);
        }

        return [
            'title' => ['required', $rule_title_unique, 'max:255'],
            'url' => ['required' , 'url'],
        ];
    }
}
