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
        .gallery {
            margin-top: 20px;
        }
        .gallery-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .gallery-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .gallery-item {
            width: calc(33.333% - 10px);
            margin-bottom: 10px;
        }
        .gallery-item img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 4px;
        }
        @page {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="content">
    <h1>{{ $house->name }}</h1>
    <div class="image-wrapper">
        @php
            try {
                $imagePath = storage_path('app/public/houses/' . $house->image);
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageType = in_array($imageType, ['jpg', 'jpeg', 'png', 'gif']) ? $imageType : 'jpeg';
                $validImage = file_exists($imagePath) && is_readable($imagePath);
                $imageData = $validImage ? base64_encode(file_get_contents($imagePath)) : '';
            } catch (Exception $e) {
                $imageData = '';
                $imageType = 'jpeg';
                $validImage = false;
            }
        @endphp

        @if($validImage && $imageData)
            <img src="data:image/{{ $imageType }};base64,{{ $imageData }}" alt="House image" class="house-image">
        @else
            <p>werkt niet</p>
        @endif
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
            <p><strong>Geo-opties:</strong></p>
            @if($house->geoOptions && count($house->geoOptions) > 0)
                <ul>
                    @foreach($house->geoOptions as $option)
                        <li>{{ $option->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>Geen geo-opties beschikbaar</p>
            @endif
        </div>
    </div>

    <div class="gallery">
        <div class="gallery-title">Fotogalerij</div>
        <div class="gallery-grid">
            @if($house->images && count($house->images) > 0)
                @foreach($house->images as $image)
                    @php
                        try {
                            $galleryImagePath = storage_path('app/public/houses/' . $image->image_path);
                            $galleryImageType = pathinfo($galleryImagePath, PATHINFO_EXTENSION);
                            $galleryImageType = in_array($galleryImageType, ['jpg', 'jpeg', 'png', 'gif']) ? $galleryImageType : 'jpeg';
                            $validGalleryImage = file_exists($galleryImagePath) && is_readable($galleryImagePath);
                            $galleryImageData = $validGalleryImage ? base64_encode(file_get_contents($galleryImagePath)) : '';
                        } catch (Exception $e) {
                            $galleryImageData = '';
                            $galleryImageType = 'jpeg';
                            $validGalleryImage = false;
                        }
                    @endphp

                    <div class="gallery-item">
                        @if($validGalleryImage && $galleryImageData)
                            <img src="data:image/{{ $galleryImageType }};base64,{{ $galleryImageData }}" alt="Huis afbeelding">
                        @else
                            <p>werkt niet</p>
                        @endif
                    </div>
                @endforeach
            @else
                <p>Geen extra afbeeldingen beschikbaar</p>
            @endif
        </div>
    </div>
</div>
</body>
</html>
