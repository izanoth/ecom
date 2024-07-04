<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bem-vindo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        @yield('content')
    </div>
</body>
</html>
