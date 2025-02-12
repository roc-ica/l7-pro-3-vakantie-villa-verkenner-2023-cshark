<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My Website' }}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
<main>
    {{ $slot }}
</main>
</body>
</html>
