<x-layout>
    <x-elements-card class="mx-4">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">Реєстрація</h2>
        </header>

        <form method="POST" action="{{ route('user.store') }}">
            @csrf
            <div class="mb-6">
                <label for="login" class="inline-block text-lg mb-2"> Номер телефону </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full text-black" name="login"
                       value="{{old('login')}}"/>

                @error('login')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="card_number" class="inline-block text-lg mb-2">
                    Номер картки <i>(не обовʼязково)</i>
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full text-black" name="card_number"
                       value="{{old('card_number')}}"/>

                @error('card_number')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="inline-block text-lg mb-2">
                    Пароль
                </label>
                <input type="password" class="border border-gray-200 rounded p-2 w-full text-black" name="password"
                       value="{{old('password')}}"/>

                @error('password')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password2" class="inline-block text-lg mb-2">
                    Підтвердження паролю
                </label>
                <input type="password" class="border border-gray-200 rounded p-2 w-full text-black"
                       name="password_confirmation"
                       value="{{old('password_confirmation')}}"/>

                @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-accent text-white rounded py-2 px-4 hover:bg-neutral">
                    Створити користувача
                </button>
            </div>

            <div class="mt-8">
                <p>
                    Вже маєте обліковий запис?
                    <a href="{{ route('user.login') }}" class="text-accent">Увійти</a>
                </p>
            </div>
        </form>
    </x-elements-card>
</x-layout>
