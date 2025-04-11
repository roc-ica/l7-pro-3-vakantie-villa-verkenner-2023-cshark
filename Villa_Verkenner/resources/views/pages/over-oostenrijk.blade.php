<x-layout title="over-oostenrijk">
    <main class="over-oostenrijk">

        <!-- Koptekst sectie -->
        <section class="koptext">
            <h1>Over Oostenrijk</h1>
            <p>Het hart van de Alpen</p>
        </section>

        <!-- Rechter sectie met afbeelding -->
        <div class="right-content">
            <img src="{{ asset('images/vlagfoto.jpg') }}" alt="Oostenrijk afbeelding" />
        </div>

        <!-- Nieuwe container voor main-content en afbeelding rechts -->
        <div class="content-container">
            <!-- Linker sectie -->
            <section class="main-content">
                <div class="left-content">
                    <h2 class="info-title">Oostenrijk Info</h2>
                    <div class="info-block">
                        <p>Oostenrijk, gelegen in het hart van Europa, staat bekend om zijn indrukwekkende Alpen, rijke
                            cultuur en historische steden zoals Wenen en Salzburg.</p>
                        <p>Het land is een populaire bestemming voor natuurliefhebbers, wintersporters en kunst- en
                            muziekliefhebbers.</p>
                    </div>
                    <br>
                    <h3 class="populaire-huizen-title">Populaire Huizen</h3>
                    <div class="populaire-huizen">
                        @forelse ($popularHouses as $house)
                            <div class="huis-box">
                                <div class="huis-info">
                                    <div class="oostenrijkveeg-image">
                                        <img src="{{ asset('images/verf/verf_lichtpaars3.png') }}"
                                            alt="Afbeelding met tekst" />
                                        <span>€{{ number_format($house->price, 0, ',', '.') }}</span>
                                    </div>
                                    <img src="{{ asset('storage/' . $house->primary_image) }}" alt="{{ $house->name }}"
                                        onerror="this.src='{{ asset('storage/houses/defaultImage.webp') }}'"
                                        class="house-image">
                                    <div class="huis-details">
                                        <h4 class="huis-title">{{ $house->name }}</h4>
                                        <p class="huis-adres">{{ $house->address }}</p>
                                        <a class="see-button" href="{{ route('detail', $house->id) }}">
                                            <img src="{{ asset('images/verf/verf_blauw1.png') }}" alt="image">
                                            <span>Bekijk</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-houses">
                                <p>Er zijn momenteel geen populaire huizen beschikbaar.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </main>
</x-layout>
