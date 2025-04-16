<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $house->name }} - Flyer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .house-header {
            margin-bottom: 20px;
            border-bottom: 2px solid #4682B4;
            padding-bottom: 15px;
        }

        h1 {
            color: #4682B4;
            font-size: 26px;
            margin-bottom: 5px;
        }

        .address {
            font-size: 16px;
            color: #666;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #4682B4;
            margin: 15px 0;
        }

        .main-image {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .gallery-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }

        .section {
            margin-bottom: 25px;
        }

        h2 {
            color: #4682B4;
            margin-top: 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .feature-item {
            padding: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        @media print {
            body {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .print-controls {
                display: none;
            }
        }

        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .print-btn {
            padding: 10px 15px;
            background-color: #4682B4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .print-btn:hover {
            background-color: #3a6d96;
        }
    </style>
</head>

<body>
    <div class="print-controls">
        <button id="downloadBtn" class="print-btn" onclick="generatePDF();">
            <i class="fa fa-download"></i> Download PDF
        </button>
    </div>

    <div class="house-header">
        <h1>{{ $house->name }}</h1>
        <div class="address">{{ $house->address }}</div>
        @if ($house->geoOptions->isNotEmpty())
        <div>{{ $house->geoOptions->pluck('name')->implode(', ') }}</div>
        @endif
        <div class="price">€{{ number_format($house->price, 0, ',', '.') }}</div>
    </div>

    <div class="section">
        <img class="main-image" src="{{ $baseUrl . '/storage/' . $house->primary_image }}" alt="{{ $house->name }}">
    </div>

    <div class="section">
        <h2>Beschrijving</h2>
        <p>{{ $house->description }}</p>
    </div>

    <div class="section">
        <h2>Kenmerken</h2>
        <div class="features-grid">
            @if ($house->features->isNotEmpty())
            @foreach ($house->features as $feature)
            <div class="feature-item">• {{ $feature->name }}</div>
            @endforeach
            @endif
            <div class="feature-item">• Slaapkamers: {{ $house->rooms }}</div>
            <div class="feature-item">• Status: {{ $house->status }}</div>
        </div>
    </div>

    @if ($house->images->where('is_primary', false)->count() > 0)
    <div class="section">
        <h2>Meer foto's</h2>
        <div class="image-gallery">
            @foreach($house->images->where('is_primary', false)->take(6) as $image)
            <img class="gallery-image" src="{{ $baseUrl . '/storage/' . $image->image_path }}" alt="{{ $house->name }}">
            @endforeach
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Gegenereerd op: {{ date('d-m-Y H:i') }}</p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script>
        function generatePDF() {
            document.querySelector('.print-controls').style.display = 'none';

            var element = document.body;
            var opt = {
                margin: 1,
                filename: '{{ $house->name }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'cm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf().set(opt).from(element).save().then(function() {
                setTimeout(function() {
                    document.querySelector('.print-controls').style.display = 'flex';
                }, 1000);
            });
        }
    </script>
</body>

</html>