<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<header>
    <h1>Admin Panel</h1>
</header>

<main>
    {{ $slot }}
</main>
</body>
</html>
