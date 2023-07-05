<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nickname' => 'required|unique:users,nickname',
            'first_name' => 'required|min:3|max:32',
            'last_name' => 'required|min:3|max:32',
            'email' => 'required|email|unique:credentials,email',
            'password' => 'required|min:8|max:35|alpha_dash'
        ];
    }
}
