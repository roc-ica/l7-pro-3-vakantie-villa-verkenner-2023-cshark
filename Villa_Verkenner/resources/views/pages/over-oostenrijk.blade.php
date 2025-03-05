<x-layout title="over-oostenrijk">
    <!-- Koptekst sectie -->
    <section class="koptext">
        <h1>Over Oostenrijk</h1>
        <p>Het hart van de Alpen</p>
    </section>

    <!-- Main content sectie -->
    <section class="main-content">
        <!-- Linker sectie met info blok -->
        <div class="left-content">
            <h2 class="info-title">Oostenrijk Info</h2>
            <div class="info-block">
                <p>Oostenrijk, gelegen in het hart van Europa, staat bekend om zijn indrukwekkende Alpen, rijke cultuur en historische steden zoals Wenen en Salzburg. Het land is een populaire bestemming voor natuurliefhebbers, wintersporters en kunst- en muziekliefhebbers.</p>
                <p>Oostenrijk biedt veel meer dan alleen bergen; de wijngaarden langs de Donau, het cultureel erfgoed en de vele kastelen maken het een veelzijdige bestemming voor elke reiziger.</p>
            </div>
            

            <!-- Nieuwe sectie voor Populaire Huizen -->
            <h3 class="populaire-huizen-title">Populaire Huizen</h3>
            <div class="populaire-huizen">
                <div class="huis-box">
                    <div class="huis-info">
                        <span class="prijs">€450.000</span>
                        <img src="{{ asset('images/huis1.webp') }}" alt="Populair huis 1" />
                        <div class="huis-details">
                            <h4 class="huis-title">Gezellig huis in de bergen</h4>
                            <p class="huis-adres">Weg 123, Salzburg</p>
                            <p class="huis-plaatsnaam">Salzburg, Oostenrijk</p>
                            <a href="{{ route('aanbod') }}" class="bekijk-link">Bekijk</a>
                        </div>
                    </div>
                </div>
                <div class="huis-box">
                    <div class="huis-info">
                        <span class="prijs">€600.000</span>
                        <img src="{{ asset('images/huis2.jpg') }}" alt="Populair huis 2" />
                        <div class="huis-details">
                            <h4 class="huis-title">Modern huis in het centrum</h4>
                            <p class="huis-adres">Laan 45, Wenen</p>
                            <p class="huis-plaatsnaam">Wenen, Oostenrijk</p>
                            <a href="{{ route('aanbod') }}" class="bekijk-link">Bekijk</a>
                        </div>
                    </div>
                </div>
                <div class="huis-box">
                    <div class="huis-info">
                        <span class="prijs">€750.000</span>
                        <img src="{{ asset('images/huis3.webp') }}" alt="Populair huis 3" />
                        <div class="huis-details">
                            <h4 class="huis-title">Landhuis met uitzicht</h4>
                            <p class="huis-adres">Bosweg 10, Innsbruck</p>
                            <p class="huis-plaatsnaam">Innsbruck, Oostenrijk</p>
                            <a href="{{ route('aanbod') }}" class="bekijk-link">Bekijk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-content">
            <img src="{{ asset('images/vlagfoto.jpg') }}" alt="Oostenrijk afbeelding"/>
        </div>
    </section>
</x-layout>
