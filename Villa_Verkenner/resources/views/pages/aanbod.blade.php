<x-layout title="Aanbod">
    <main class="aanbod-main">
        <div class="search">
            <input type="text" name="search" placeholder="Zoek in Oostenrijk..." value="{{ request('search') }}">
            <button title="Search"><i class="fa-solid fa-location-dot"></i></button>
        </div>

        <h1 class="title-top">Huizen in Oostenrijk</h1>

        <form id="filterForm" method="GET" action="{{ route('aanbod') }}">
            <div class="filter-section">
                <div class="filter-one">
                    <div class="values">
                        <span id="range1">{{ number_format(request('min_price', 150000), 0, ',', '.') }}</span>
                        <span> &dash; </span>
                        <span id="range2">{{ number_format(request('max_price', 900000), 0, ',', '.') }}</span>
                    </div>
                    <div class="slider">
                        <div class="slider-track"></div>
                        <input type="range" name="min_price" min="25000" max="2000000"
                            value="{{ request('min_price', '25000') }}" id="slider-1" oninput="slideOne()">
                        <input type="range" name="max_price" min="25000" max="2000000"
                            value="{{ request('max_price', '2000000') }}" id="slider-2" oninput="slideTwo()">
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
                            @foreach ($allFeatures as $feature)
                                <div class="option">
                                    <input type="checkbox" name="features[]" value="{{ $feature->id }}"
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
                            @foreach ($allGeoOptions as $geoOption)
                                <div class="option">
                                    <input type="checkbox" name="geoOptions[]" value="{{ $geoOption->id }}"
                                        {{ is_array(request('geoOptions')) && in_array($geoOption->id, request('geoOptions')) ? 'checked' : '' }}>
                                    <span>{{ $geoOption->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </form>
        <!-- House Cards -->
        <div class="card-container">
            @include('partials.houses')
        </div>

    </main>
</x-layout>
