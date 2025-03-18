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
                        <p>Oostenrijk, gelegen in het hart van Europa, staat bekend om zijn indrukwekkende Alpen, rijke cultuur en historische steden zoals Wenen en Salzburg.</p>
                        <p>Het land is een populaire bestemming voor natuurliefhebbers, wintersporters en kunst- en muziekliefhebbers.</p>
                    </div>
                    <br>
                    <h3 class="populaire-huizen-title">Populaire Huizen</h3>
<div class="populaire-huizen">
    <!-- Eerste huis -->
    <div class="huis-box">
        <div class="huis-info">
            <div class="oostenrijkveeg-image">
                <img src="{{ asset('images/verf/verf_donkerpaars1.png') }}" alt="Afbeelding met tekst" />
                <span>€450.000</span>
            </div>
            <img src="{{ asset('images/huis1.webp') }}" alt="Populair huis 1" />
            <div class="huis-details">
                <h4 class="huis-title">Gezellig huis in de bergen</h4>
                <p class="huis-adres">Weg 123, Salzburg</p>
                <p class="huis-plaatsnaam">Salzburg, Oostenrijk</p>
                <a class="see-button" href="">
                    <img src="{{ asset('images/verf/verf_blauw1.png') }}" alt="image">
                    <span>Bekijk</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Tweede huis -->
    <div class="huis-box">
        <div class="huis-info">
            <div class="oostenrijkveeg-image">
                <img src="{{ asset('images/verf/verf_donkerpaars1.png') }}" alt="Afbeelding met tekst" />
                <span>€600.000</span>
            </div>
            <img src="{{ asset('images/huis2.jpg') }}" alt="Populair huis 2" />
            <div class="huis-details">
                <h4 class="huis-title">Modern huis in het centrum</h4>
                <p class="huis-adres">Laan 45, Wenen</p>
                <p class="huis-plaatsnaam">Wenen, Oostenrijk</p>
                <a class="see-button" href="">
                    <img src="{{ asset('images/verf/verf_blauw1.png') }}" alt="image">
                    <span>Bekijk</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Derde huis -->
    <div class="huis-box">
        <div class="huis-info">
            <div class="oostenrijkveeg-image">
                <img src="{{ asset('images/verf/verf_donkerpaars1.png') }}" alt="Afbeelding met tekst" />
                <span>€750.000</span>
            </div>
            <img src="{{ asset('images/huis3.webp') }}" alt="Populair huis 3" />
            <div class="huis-details">
                <h4 class="huis-title">Landhuis met uitzicht</h4>
                <p class="huis-adres">Bosweg 10, Innsbruck</p>
                <p class="huis-plaatsnaam">Innsbruck, Oostenrijk</p>
                <a class="see-button" href="">
                    <img src="{{ asset('images/verf/verf_blauw1.png') }}" alt="image">
                    <span>Bekijk</span>
                </a>
            </div>
        </div>
    </div>
</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </main>
</x-layout>
