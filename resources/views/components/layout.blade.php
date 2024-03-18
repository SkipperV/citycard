<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Citycard</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#2b2a33",
                        secondary: "#1e1e1e",
                        accent: "#9f86ff",
                        neutral: "#D4ADFC",
                    },
                },
            },
        };
    </script>
</head>
<body class="flex flex-col min-h-screen bg-primary text-white">
<nav class="flex justify-between items-center bg-secondary h-12 mb-4">
    <a class="ml-4 text-xl" href="/">
        Citycard
    </a>
    <ul class="flex space-x-6 mr-6 text-lg">
        @auth
            <li><p>{{auth()->user()->login}}</p></li>
            <li>
                <form method="POST" action="/logout">
                    @csrf
                    <button class="hover:text-accent">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Вийти
                    </button>
                </form>
            </li>
        @else
            <li>
                <a href="/register" class="hover:text-accent">
                    <i class="fa-solid fa-user-plus"></i> Зареєструватися
                </a>
            </li>
            <li>
                <a href="/login" class="hover:text-accent">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Увійти
                </a>
            </li>
        @endauth
    </ul>
</nav>

<main class="flex-grow">
    {{$slot}}
</main>

<footer
    class="bottom-0 left-0 w-full flex items-center justify-start font-bold bg-secondary h-12 mt-24 opacity-90 md:justify-center">
    <p class="ml-2">&copy; 2024, SkipperV</p>
</footer>
</body>
</html>
