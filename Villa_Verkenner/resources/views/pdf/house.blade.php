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

        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.15;
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
    </style>
</head>
<body>
<img class="background-image" src="{{ public_path('images/background.jpg') }}" alt="">

<div class="content">
    <h1>{{ $house->name }}</h1>

    <div class="image-wrapper">
        <img src="{{ public_path('storage/' . $house->primary_image) }}" alt="House image" class="house-image">
    </div>

    <div class="details">
        <p><strong>Beschrijving:</strong> {{ $house->description }}</p>
        <p><strong>Prijs:</strong> €{{ number_format($house->price, 0, ',', '.') }}</p>
        <p><strong>Kamers:</strong> {{ $house->rooms }}</p>
    </div>
</div>
</body>
</html>
