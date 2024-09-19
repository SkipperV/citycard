<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'transport_type' => 'required|in:Автобус,Тролейбус',
            'ticket_type' => 'required|in:Стандартний,Дитячий,Студентський,Пільговий,Спеціальний',
            'price' => 'required|numeric'
        ];
    }
}
