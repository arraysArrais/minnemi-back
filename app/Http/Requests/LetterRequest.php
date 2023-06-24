<?php

namespace App\Http\Requests;

use App\Rules\LetterDate;
use Illuminate\Foundation\Http\FormRequest;

class LetterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            '*' => 'required',
            'title' => 'min:3|max:255',
            'content' => 'min:100|max:65000',
            'email' => 'exists:credentials,email',
            'date_to_send' => ['date_format:Y-m-d'],
            'visibility_id' => 'exists:visibility_types,id',
            'user_id' => 'exists:users,id'
        ];
    }
}
