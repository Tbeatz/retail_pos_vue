<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
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
        return [
            'name' => 'required|string',
            'business_type_id' => 'required',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'currency_type_id' => 'required',
            'tax_type_id' => 'required',
        ];
    }
}
