<?php

namespace App\Http\Requests;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TenantRequest extends FormRequest
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
            'id' => 'required',
            'domain' => 'required|string',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(Tenant::class)->ignore($this->id)],
            'phone' => ['required'],
            'address' => ['required'],
            'name' => 'required',
            'password' => 'required',
        ];
    }
}
