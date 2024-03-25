<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $avatar_rule = (is_string($this->avatar) || $this->avatar == null) ? '' : 'file|mimes:png,jpg,jpeg|max:5120';
        $password_rule = $this->state == 'edit' ? '' : 'required|min:8';
        return [
            'name' => 'required|string',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone' => 'required|max:255',
            'address' => 'required|string',
            'avatar' => $avatar_rule,
            'password' => $password_rule,
            'position_id' => 'required',
            tenant() ? 'business_id' : '' => tenant() ? 'required' : '',
            'role_id' => 'required',
        ];
    }
}
