<x-layout>
    <h1>Вхід</h1>
    <form method="POST" action="/users/auth">
        @csrf
        <div>
            <label for="login">Номер телефону</label>
            <input type="text" name="login" placeholder="+380..." value="{{old('login')}}">
            @error('login')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="password">Пароль</label>
            <input name="password" type="password">
            @error('password')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <button>Увійти</button>
        <p>Не маєте облікового запису? <a href="/register">Зареєструватися</a></p>
    </form>
</x-layout>
