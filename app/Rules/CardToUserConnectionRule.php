<?php

namespace App\Rules;

use App\Models\Card;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardToUserConnectionRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value) {
            if (strlen($value) != 11) {
                $fail('Номер картки складається із 11 цифр.');
            }

            if (!(Card::where('number', $value)->exists())) {
                $fail('Картки з таким номером не існує.');
            }

            if (!(Card::where('number', $value)
                ->whereNull('user_id')
                ->exists())) {
                $fail('Дана картка вже прив\'язана до іншого номеру телефону.');
            }
        }
    }
}
