<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'preferred_name' => ['required', 'string'],
            'cpf' => ['nullable', 'string'],
            'father_name' => ['required', 'string'],
            'mother_name' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
        ];
    }
}
