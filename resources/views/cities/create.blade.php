<x-layout>
    <h1>Додати місто</h1>
    <form method="POST" action="/admin/cities">
        @csrf
        <div>
            <label for="region">Область</label>
            <input type="text" name="region" value="{{old('region')}}">
            @error('region')
                <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="name">Назва міста</label>
            <input type="text" name="name" value="{{old('name')}}">
            @error('name')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <button>
                Додати
            </button>
            <a href="/admin/cities">Назад</a>
        </div>
    </form>
</x-layout>
