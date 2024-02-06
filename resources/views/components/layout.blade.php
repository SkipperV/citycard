<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Citycard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<header>
    @php
        $home = Auth::check() ? (Auth::user()->is_admin ? '/admin/cities' : "/profile") : "/login"
    @endphp
    <nav>
        <h2 class="site-title">
            <a href={{$home}}>
                Citycard
            </a>
        </h2>
        <ul>
            @auth
                <li><p>{{auth()->user()->login}}</p></li>
                <li>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit">Вийти</button>
                    </form>
                </li>
            @else
                <li><a href="/register">Зареєструватися</a></li>
                <li><a href="/login">Увійти</a></li>
            @endauth
        </ul>
    </nav>
</header>
<main>
    {{$slot}}
</main>
<footer>
    <div>
        <p>Citycard</p>
        <p>&copy; 2024 SkipperV</p>
    </div>
</footer>
</body>
</html>
