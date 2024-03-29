<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use App\Rules\CardToUserConnectionValidationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('users.profile', [
            'cards' => Card::where('user_id', Auth::user()->getAuthIdentifier())->get()
        ]);
    }

    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
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
        if ($request->card_number)
            Card::where('number', $request->card_number)->update(['user_id' => $user->id]);

        auth()->login($user);

        return redirect('/profile');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function login(Request $request)
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'login' => ['required'],
            'password' => ['required']
        ], [
            'login.required' => 'Обов\'язкове поле.',
            'password.required' => 'Обов\'язкове поле.',
        ]);
        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors(['login' => 'Дані не співпадають'])->onlyInput('login');
    }
}
