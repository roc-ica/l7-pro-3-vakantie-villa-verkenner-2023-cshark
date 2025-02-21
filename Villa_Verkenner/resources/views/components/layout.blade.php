@props(['title'])

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ empty($title) ? 'VillaVerkenner' : $title . ' | VillaVerkenner' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
<nav class="nav">
    <a href="{{ route('landing') }}">Home</a>
    <a href="{{ route('aanbod') }}">Aanbod</a>
    <a href="{{ route('over-oostenrijk') }}">Over Oostenrijk</a>
</nav>
<img class="logo" src="{{ asset('images/austria-flag.jpg') }}" alt="Logo"">
<main>
    {{ $slot }}
</main>
<main>
    {{ $slot }}
</main>
</body>
</html>
