<x-layout>
    <h1>Зміна {{$city->name}}</h1>
    <form method="POST" action="/admin/cities/{{$city->id}}">
        @csrf
        @method('PUT')
        <div>
            <label for="region">Область</label>
            <input type="text" name="region" value="{{$city->region}}">
            @error('region')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="name">Назва міста</label>
            <input type="text" name="name" value="{{$city->name}}">
            @error('name')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <button>
                Змінити
            </button>
            <a href="/admin/cities">Назад</a>
        </div>
    </form>
</x-layout>
