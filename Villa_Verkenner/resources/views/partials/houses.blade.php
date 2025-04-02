@if ($houses->isEmpty())
    <p class="notFound">Geen huizen gevonden.</p>
@else
    @foreach ($houses as $house)
        <div class="house">
            <div class="price">
                <img src="{{ asset('images/verf/verf_lichtpaars.webp') }}" alt="image">
                <span>€{{ number_format($house->price, 0, ',', '.') }}</span>
            </div>
            {{-- Use a placeholder image for the house --}}
            <img src="https://picsum.photos/600/400" alt="Lorem Picsum House Image">
            <h1 class="house-title">{{ $house->name }}</h1>
            <p class="house-info">{{ $house->address }}</p>
            <a class="see-button" href="{{ route('detail', $house->id) }}">
                <img src="{{ asset('images/verf/verf_blauw1.png') }}" alt="image">
                <span>Bekijk</span>
            </a>
            <br>
            <p class="house-info">
                {{ $house->rooms }} slaapkamers |
                @if ($house->geoOptions->isNotEmpty())
                    {{ $house->geoOptions->pluck('name')->implode(', ') }}
                @endif
                @if ($house->features->isNotEmpty())
                    | Features: {{ $house->features->pluck('name')->implode(', ') }}
                @endif
            </p>
        </div>
    @endforeach
@endif