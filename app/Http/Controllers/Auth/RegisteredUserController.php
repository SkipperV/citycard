<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\CardToUserConnectionValidationRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $formFields = $request->validate([
            'login' => ['required', 'regex:/^\+380\d{9}$/', 'unique:users,login'],
            'card_number' => [new CardToUserConnectionValidationRule],
            'password' => ['required', 'confirmed', 'min:6']
        ], [
            'login.required' => 'Обов\'язкове поле.',
            'login.regex' => 'Введено невірний формат.',
            'login.unique' => 'Користувач з даним номером телефону вже існує.',
            'card_number.size' => 'Введено невірний формат.',
            'card_number.exists' => 'Такої картки не існує',
            'password.required' => 'Обов\'язкове поле.',
            'password.confirmed' => 'Паролі не співпадають.',
            'password.min' => 'Пароль повинен містити від 6 символів.',
        ]);
        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);
        if ($request->card_number) {
            Card::where('number', $request->card_number)->update(['user_id' => $user->id]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
