<x-layout>
    <h1>Створення нового користувача</h1>
    <form method="POST" action="/users">
        @csrf
        <div>
            <label for="login">Номер телефону</label>
            <input type="text" name="login" placeholder="+380..." value="{{old('login')}}">
            @error('login')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="card_number">
                Номер картки
                <span class="tooltip">ⓘ
                    <span class="tooltiptext">Номер "фізичної" картки, до якої потрібно прив'язати новий профіль.
                        <br>Якщо такої немає - можна залишити поле пустим</span>
                </span>
            </label>
            <input name="card_number" type="text" value="{{old('card_number')}}">
            @error('card_number')
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
        <div>
            <label for="password_confirmation">Повторіть пароль</label>
            <input name="password_confirmation" type="password">
            @error('password_confirmation')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <button>Створити користувача</button>
        <p>Вже маєте обліковий запис? <a href="/login">Увійти</a></p>
    </form>
</x-layout>
