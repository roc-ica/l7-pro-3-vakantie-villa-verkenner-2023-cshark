@props(['title'])

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-light.css">
    <title>{{ empty($title) ? 'VillaVerkenner' : $title . ' | VillaVerkenner' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>

<header>
  <img class="logo" src="{{ asset('images/austria-flag.jpg') }}" alt="Logo"">
  <nav class="nav">
      <a href="{{ route('landing') }}">Home</a>
      <a href="{{ route('aanbod') }}">Aanbod</a>
      <a href="{{ route('over-oostenrijk') }}">Over Oostenrijk</a>
  </nav>
</header>

<main>
    {{ $slot }}
</main>

<footer>
    <p>&copy; CShark {{ date('Y') }}</p>
</footer>

</body>
</html>
