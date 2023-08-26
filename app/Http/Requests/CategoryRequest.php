<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CategoryRequest extends FormRequest
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
        $rule_title_unique = Rule::unique('categories', 'name');
        if ($this->method() !== 'POST') {
            $rule_title_unique->ignore($this->category->id);
        }
        return [
            //
            'name' =>[ 'required','string',$rule_title_unique]
        ];
    }
}
