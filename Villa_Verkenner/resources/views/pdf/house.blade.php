<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $house->name }} - PDF</title>
    <style>
        body {
            font-family: sans-serif;
        }
        .image-wrapper {
            text-align: center;
            margin-bottom: 20px;
        }
        img {
            max-width: 100%;
            max-height: 300px;
        }
    </style>
</head>
<body>
<h1>{{ $house->name }}</h1>

<div class="image-wrapper">
    <img src="{{ public_path('storage/' . $house->primary_image) }}" alt="House image">
</div>

<p><strong>Description:</strong> {{ $house->description }}</p>
<p><strong>Price:</strong> €{{ number_format($house->price, 0, ',', '.') }}</p>
<p><strong>Rooms:</strong> {{ $house->rooms }}</p>
</body>
</html>
