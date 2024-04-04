<x-layout>
    <div class="mx-4">
        <x-elements-card>
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-1">
                    Вхід
                </h2>
            </header>

            <form method='POST' action="{{ route('user.authenticate') }}">
                @csrf
                <div class="mb-6">
                    <label for="login" class="inline-block text-lg mb-2">
                        Номер телефону
                    </label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full text-black" name="login"
                           value="{{old('login')}}"/>

                    @error('login')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="inline-block text-lg mb-2">
                        Пароль
                    </label>
                    <input
                        type="password" class="border border-gray-200 rounded p-2 w-full text-black" name="password"/>

                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <button type="submit" class="bg-accent text-white rounded py-2 px-4 hover:bg-neutral">
                        Увійти
                    </button>
                </div>

                <div class="mt-8">
                    <p>
                        Не маєте облікового запису?
                        <a href="{{ route('user.create') }}" class="text-accent">
                            Зареєструватися
                        </a>
                    </p>
                </div>
            </form>
        </x-elements-card>
    </div>
</x-layout>
