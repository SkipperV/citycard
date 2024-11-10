<?php

namespace App\Http\Requests;

use App\Rules\CardToUserConnectionRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegisteredUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'regex:/^\+380\d{9}$/', 'unique:users,login'],
            'card_number' => [new CardToUserConnectionRule],
            'password' => ['required', 'confirmed', 'min:6']
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Обов\'язкове поле.',
            'login.regex' => 'Введено невірний формат.',
            'login.unique' => 'Користувач з даним номером телефону вже існує.',
            'card_number.size' => 'Введено невірний формат.',
            'card_number.exists' => 'Такої картки не існує',
            'password.required' => 'Обов\'язкове поле.',
            'password.confirmed' => 'Паролі не співпадають.',
            'password.min' => 'Пароль повинен містити від 6 символів.',
        ];
    }
}
