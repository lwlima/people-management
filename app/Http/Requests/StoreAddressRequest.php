<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAddressRequest extends FormRequest
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
            'person_id' => 'required',
            'residential' => 'required_without:commercial|array',
            'residential.street' => 'required_if:residential,array|string',
            'residential.number' => 'required_if:residential,array|string',
            'residential.city' => 'required_if:residential,array|string',
            'residential.state' => 'required_if:residential,array|string',
            'residential.cep' => 'required_if:residential,array|string',

            'commercial' => 'required_without:residential|array',
            'commercial.street' => 'required_if:commercial,array|string',
            'commercial.number' => 'required_if:commercial,array|string',
            'commercial.city' => 'required_if:commercial,array|string',
            'commercial.state' => 'required_if:commercial,array|string',
            'commercial.cep' => 'required_if:commercial,array|string',
        ];
    }
}
