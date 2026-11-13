<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // check Role access
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           
                    'name' => ['required', 'max:100'],
                    'gst'  => ['nullable','between:0,100'],
                    'category_id' => ['required','exists:categories,id'],
                    'brand_id' => ['required','exists:brands,id'],
                    'gender_id' => ['required','exists:genders,id'],
                    'product_for'=>['required','in:A,K'],
                    'short_description' => ['nullable','max:200'],
                    'long_description' => ['nullable','max:800'],
                     'is_featured'=>['nullable','in:"0","1"'],
                    'is_promotional'=>['nullable','in:"0","1"'],
                    'status'=>['nullable','in:"0","1"'],
                    'related_product_hash_tag'=>['nullable'],
                    'image' => [
                                'nullable', 
                                'image', 
                                'mimes:png,jpg,jpeg,webp,gif', 
                                'max:3072' // Limits size to 3MB (3072 KB)
                            ],
            ];
    }
}
