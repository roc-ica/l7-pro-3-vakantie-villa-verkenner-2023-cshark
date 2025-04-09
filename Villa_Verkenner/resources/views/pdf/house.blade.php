<!DOCTYPE html>
<html>
<head>
    <title>{{ $house->name }} Details</title>
</head>
<body>
<h1>{{ $house->name }}</h1>
<img src="{{ asset('storage/' . $house->primary_image) }}" alt="{{ $house->name }}">
<p>{{ $house->description }}</p>
<p>Price: €{{ number_format($house->price, 0, ',', '.') }}</p>
<p>Rooms: {{ $house->rooms }}</p>
</body>
</html>
