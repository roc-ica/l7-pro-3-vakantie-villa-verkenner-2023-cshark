<x-layout title="Aanbod">
    <main class="aanbod-main">
      <div class="search">
        <input type="text" placeholder="Zoek in Oostenrijk...">
        <button title="Search"><i class="fa-solid fa-location-dot"></i></button>
      </div>

      <h1 class="title-top">Huizen in Oostenrijk</h1>

      <div class="filter-section">
        <div class="filter-one">
          <div class="values">
            <span id="range1">€150.000</span>
            <span> &dash; </span>
            <span id="range2">€900.000</span>
          </div>
          <div class="slider">
            <div class="slider-track"></div>
            <input type="range" min="150000" max="900000" value="150000" id="slider-1" oninput="slideOne()">
            <input type="range" min="150000" max="900000" value="900000" id="slider-2" oninput="slideTwo()">
          </div>
        </div>
        <div class="filter-two">
        <div class="dropdown">
            <div class="dropdown-toggle">
              <span>Eigenschappen</span>
              <i class="fa-sharp fa-solid fa-chevron-down"></i>
            </div>
            <div class="dropdown-content">
              <div class="option">
                <input type="checkbox">
                <span>placeholder</span>
              </div>
              <div class="option">
                <input type="checkbox">
                <span>placeholder</span>
              </div>
              <div class="option">
                <input type="checkbox">
                <span>placeholder</span>
              </div>
              <div class="option">
                <input type="checkbox">
                <span>placeholder</span>
              </div>
            </div>
          </div>
        </div>
        <div class="filter-three">
        <div class="dropdown dropdown">
            <div class="dropdown-toggle">
              <span>Liggingsopties</span>
              <i class="fa-sharp fa-solid fa-chevron-down"></i>
            </div>
            <div class="dropdown-content">
              <div class="option">
                <input type="checkbox">
                <span>placeholder</span>
              </div>
              <div class="option">
                <input type="checkbox">
                <span>placeholder</span>
              </div>
              <div class="option">
                <input type="checkbox">
                <span>placeholder</span>
              </div>
              <div class="option">
                <input type="checkbox">
                <span>placeholder</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-container">
        <div class="house">
          <div class="price">
            <img src="{{ asset('images/verf/verf_lichtpaars.webp') }}" alt="image">
            <span>€150.000</span>
          </div>
          <img src="{{ asset('images/house-image.webp') }}" alt="image of a house">
          <h1 class="house-title">Title of the house</h1>
          <p class="house-info">adres en plaatsnaam van huis</p>
          <a class="see-button" href="#">
            <img src="{{ asset('images/verf/donker-groen.png') }}" alt="image">
            <span>Bekijk</span>
          </a>
          <br>
          <p class="house-info">3 slaapkamers, ligginsgoptie, eingenschap</p>
        </div>
        <div class="house">
          <div class="price">
            <img src="{{ asset('images/verf/verf_lichtpaars.webp') }}" alt="image">
            <span>€150.000</span>
          </div>
          <img src="{{ asset('images/house-image.webp') }}" alt="image of a house">
          <h1 class="house-title">Title of the house</h1>
          <p class="house-info">adres en plaatsnaam van huis</p>
          <a class="see-button" href="#">
            <img src="{{ asset('images/verf/donker-groen.png') }}" alt="image">
            <span>Bekijk</span>
          </a>
          <br>
          <p class="house-info">3 slaapkamers, ligginsgoptie, eingenschap</p>
        </div>
        <div class="house">
          <div class="price">
            <img src="{{ asset('images/verf/verf_lichtpaars.webp') }}" alt="image">
            <span>€150.000</span>
          </div>
          <img src="{{ asset('images/house-image.webp') }}" alt="image of a house">
          <h1 class="house-title">Title of the house</h1>
          <p class="house-info">adres en plaatsnaam van huis</p>
          <a class="see-button" href="#">
            <img src="{{ asset('images/verf/donker-groen.png') }}" alt="image">
            <span>Bekijk</span>
          </a>
          <br>
          <p class="house-info">3 slaapkamers, ligginsgoptie, eingenschap</p>
        </div>
        <div class="house">
          <div class="price">
            <img src="{{ asset('images/verf/verf_lichtpaars.webp') }}" alt="image">
            <span>€150.000</span>
          </div>
          <img src="{{ asset('images/house-image.webp') }}" alt="image of a house">
          <h1 class="house-title">Title of the house</h1>
          <p class="house-info">adres en plaatsnaam van huis</p>
          <a class="see-button" href="#">
            <img src="{{ asset('images/verf/donker-groen.png') }}" alt="image">
            <span>Bekijk</span>
          </a>
          <br>
          <p class="house-info">3 slaapkamers, ligginsgoptie, eingenschap</p>
        </div>
        <div class="house">
          <div class="price">
            <img src="{{ asset('images/verf/verf_lichtpaars.webp') }}" alt="image">
            <span>€150.000</span>
          </div>
          <img src="{{ asset('images/house-image.webp') }}" alt="image of a house">
          <h1 class="house-title">Title of the house</h1>
          <p class="house-info">adres en plaatsnaam van huis</p>
          <a class="see-button" href="#">
            <img src="{{ asset('images/verf/donker-groen.png') }}" alt="image">
            <span>Bekijk</span>
          </a>
          <br>
          <p class="house-info">3 slaapkamers, ligginsgoptie, eingenschap</p>
        </div>
        <div class="house">
          <div class="price">
            <img src="{{ asset('images/verf/verf_lichtpaars.webp') }}" alt="image">
            <span>€150.000</span>
          </div>
          <img src="{{ asset('images/house-image.webp') }}" alt="image of a house">
          <h1 class="house-title">Title of the house</h1>
          <p class="house-info">adres en plaatsnaam van huis</p>
          <a class="see-button" href="#">
            <img src="{{ asset('images/verf/donker-groen.png') }}" alt="image">
            <span>Bekijk</span>
          </a>
          <br>
          <p class="house-info">3 slaapkamers, ligginsgoptie, eingenschap</p>
        </div>
        <div class="house">
          <div class="price">
            <img src="{{ asset('images/verf/verf_lichtpaars.webp') }}" alt="image">
            <span>€150.000</span>
          </div>
          <img src="{{ asset('images/house-image.webp') }}" alt="image of a house">
          <h1 class="house-title">Title of the house</h1>
          <p class="house-info">adres en plaatsnaam van huis</p>
          <a class="see-button" href="#">
            <img src="{{ asset('images/verf/donker-groen.png') }}" alt="image">
            <span>Bekijk</span>
          </a>
          <br>
          <p class="house-info">3 slaapkamers, ligginsgoptie, eingenschap</p>
        </div>
        <div class="house">
          <div class="price">
            <img src="{{ asset('images/verf/verf_lichtpaars.webp') }}" alt="image">
            <span>€150.000</span>
          </div>
          <img src="{{ asset('images/house-image.webp') }}" alt="image of a house">
          <h1 class="house-title">Title of the house</h1>
          <p class="house-info">adres en plaatsnaam van huis</p>
          <a class="see-button" href="#">
            <img src="{{ asset('images/verf/donker-groen.png') }}" alt="image">
            <span>Bekijk</span>
          </a>
          <br>
          <p class="house-info">3 slaapkamers, ligginsgoptie, eingenschap</p>
        </div>
      </div>
    </main>
</x-layout>