<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransportRequest extends FormRequest
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
            'route_number' => 'required|numeric',
            'transport_type' => 'required|in:Автобус,Тролейбус',
            'route_endpoint_1' => 'required|string',
            'route_endpoint_2' => 'required|string',
        ];
    }
}
