<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $house->name }} - PDF</title>
    <style>
        body {
            font-family: Poppins, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .content {
            padding: 80px 30px 30px 30px;
            position: relative;
            z-index: 1;
        }
        img.house-image {
            max-width: 100%;
            max-height: 300px;
        }
        h1 {
            margin-top: 0;
        }
        .details {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .features-section, .geo-options {
            margin-top: 10px;
        }
        .features-section ul, .geo-options ul {
            padding-left: 20px;
        }
    </style>
</head>
<body>
<div class="content">
    <h1>{{ $house->name }}</h1>
    <div class="image-wrapper">
        <img src="{{ asset('storage/' . $house->primary_image) }}" alt="House image" class="house-image">
    </div>
    <div class="details">
        <p><strong>Adres:</strong> {{ $house->address }}</p>
        <p><strong>Beschrijving:</strong> {{ $house->description }}</p>
        <p><strong>Prijs:</strong> €{{ number_format($house->price, 0, ',', '.') }}</p>
        <p><strong>Kamers:</strong> {{ $house->rooms }}</p>

        <div class="features-section">
            <p><strong>Eigenschappen:</strong></p>
            @if($house->features && count($house->features) > 0)
                <ul>
                    @foreach($house->features as $feature)
                        <li>{{ $feature->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>Geen eigenschappen beschikbaar</p>
            @endif
        </div>

        <div class="geo-options">
            <p><strong>Locatie:</strong></p>
            @if($house->geoOptions && count($house->geoOptions) > 0)
                <ul>
                    @foreach($house->geoOptions as $option)
                        <li>{{ $option->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>Geen locatie opties</p>
            @endif
        </div>
    </div>
</div>
</body>
</html>
