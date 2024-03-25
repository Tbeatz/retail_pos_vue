<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $image_rule = (is_string($this->image) || $this->image == null) ? '' : 'file|mimes:png,jpg,jpeg|max:5120';
        return [
            'name' => 'required|string',
            'unit_id' => 'required',
            'product_code' => 'required',
            'category_id' => 'required',
            'description'=> 'string',
            'price' => 'required',
            'instock_qty' => 'required',
            'restock_qty' => 'required',
            'business_id' => 'required',
            'discount_price' => '',
            'user_id' => '',
            'image' => $image_rule,
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'This field is required',
            'image.file' => 'Must be a file',
            'image.mimes' => 'Allow: png, jpg, jpeg',
            'image.max' => 'Upload exceeds :max kilobytes.',
        ];
    }
}
