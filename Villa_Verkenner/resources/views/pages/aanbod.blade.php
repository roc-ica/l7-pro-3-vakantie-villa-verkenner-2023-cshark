<!-- filepath: resources/views/pages/aanbod.blade.php -->
<x-layout title="Aanbod">
  <main class="aanbod-main">
    <div class="search">
      <input type="text" name="search" placeholder="Zoek in Oostenrijk..." value="{{ request('search') }}">
      <button title="Search"><i class="fa-solid fa-location-dot"></i></button>
    </div>

    <h1 class="title-top">Huizen in Oostenrijk</h1>

    <!-- Wrap all filters in a GET form -->
    <form id="filterForm" method="GET" action="{{ route('aanbod') }}">
      <div class="filter-section">
        <!-- Filter One: Price Slider -->
        <div class="filter-one">
          <div class="values">
            <span id="range1">{{ number_format(request('min_price', 150000), 0, ',', '.') }}</span>
            <span> &dash; </span>
            <span id="range2">{{ number_format(request('max_price', 900000), 0, ',', '.') }}</span>
          </div>
          <div class="slider">
            <div class="slider-track"></div>
            <input type="range" name="min_price" min="150000" max="900000" value="{{ request('min_price', '150000') }}" id="slider-1" oninput="slideOne(); this.form.submit()">
            <input type="range" name="max_price" min="150000" max="900000" value="{{ request('max_price', '900000') }}" id="slider-2" oninput="slideTwo(); this.form.submit()">
          </div>
        </div>
        <!-- Filter Two: Features Dropdown -->
        <div class="filter-two">
          <div class="dropdown">
            <div class="dropdown-toggle">
              <span>Eigenschappen</span>
              <i class="fa-sharp fa-solid fa-chevron-down"></i>
            </div>
            <div class="dropdown-content">
              @foreach($allFeatures as $feature)
                <div class="option">
                  <input type="checkbox" name="features[]" value="{{ $feature->id }}" onchange="this.form.submit()"
                    {{ is_array(request('features')) && in_array($feature->id, request('features')) ? 'checked' : '' }}>
                  <span>{{ $feature->name }}</span>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <!-- Filter Three: Geo Options Dropdown -->
        <div class="filter-three">
          <div class="dropdown">
            <div class="dropdown-toggle">
              <span>Liggingsopties</span>
              <i class="fa-sharp fa-solid fa-chevron-down"></i>
            </div>
            <div class="dropdown-content">
              @foreach($allGeoOptions as $geoOption)
                <div class="option">
                  <input type="checkbox" name="geoOptions[]" value="{{ $geoOption->id }}" onchange="this.form.submit()"
                    {{ is_array(request('geoOptions')) && in_array($geoOption->id, request('geoOptions')) ? 'checked' : '' }}>
                  <span>{{ $geoOption->name }}</span>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </form>

    <!-- House Cards -->
    <div class="card-container">
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
            <img src="{{ asset('images/verf/donker-groen.png') }}" alt="image">
            <span>Bekijk</span>
          </a>
          <br>
          <p class="house-info">
            {{ $house->rooms }} slaapkamers | 
            @if($house->geoOptions->isNotEmpty())
              {{ $house->geoOptions->pluck('name')->implode(', ') }}
            @endif
            @if($house->features->isNotEmpty())
              | Features: {{ $house->features->pluck('name')->implode(', ') }}
            @endif
          </p>
        </div>
      @endforeach
    </div>
  </main>
</x-layout>