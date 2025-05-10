<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $house->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            padding: 10px;
        }

        h1 {
            color: #4682B4;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        h2 {
            color: #4682B4;
            font-size: 18px;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        .address {
            font-size: 16px;
            color: #666;
            margin-bottom: 5px;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            color: #4682B4;
            margin: 15px 0;
        }

        .section {
            margin: 15px 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .features {
            margin: 10px 0;
        }

        .feature {
            margin-bottom: 5px;
        }

        .page-break {
            page-break-before: always;
        }

        .main-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
        }

        .image-gallery {
            width: 100%;
            margin-top: 20px;
        }

        .gallery-image {
            max-width: 45%;
            margin-right: 2%;
            margin-bottom: 10px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ $house->name }}</h1>
        <div class="address">{{ $house->address }}</div>

        @if ($house->geoOptions->isNotEmpty())
        <div>{{ $house->geoOptions->pluck('name')->implode(', ') }}</div>
        @endif

        <div class="price">€{{ number_format($house->price, 0, ',', '.') }}</div>

        <div class="section">
            <img class="main-image" src="{{ $house->primary_image_url }}" alt="{{ $house->name }}">
        </div>

        <div class="section">
            <h2>Beschrijving</h2>
            <p>{{ $house->description }}</p>
        </div>

        <div class="section">
            <h2>Kenmerken</h2>
            <div class="features">
                @if ($house->features->isNotEmpty())
                @foreach ($house->features as $feature)
                <div class="feature">• {{ $feature->name }}</div>
                @endforeach
                @endif
                <div class="feature">• Slaapkamers: {{ $house->rooms }}</div>
                <div class="feature">• Status: {{ $house->status }}</div>
            </div>
        </div>

        @if(count($house->image_urls) > 0)
        <div class="page-break"></div>

        <div class="section">
            <h2>Foto's</h2>
            <div class="image-gallery">
                @foreach($house->image_urls as $index => $image)
                <img class="gallery-image" src="{{ $image['url'] }}" alt="{{ $image['alt'] }}">
                @endforeach
            </div>
        </div>
        @endif
    </div>
</body>

</html>