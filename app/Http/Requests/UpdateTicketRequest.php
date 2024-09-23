<?php

namespace App\Http\Requests;

use App\Enums\TicketType;
use App\Enums\TransportType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
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
            'transport_type' => ['required', Rule::enum(TransportType::class)],
            'ticket_type' => ['required', Rule::enum(TicketType::class)],
            'price' => 'required|numeric'
        ];
    }
}
