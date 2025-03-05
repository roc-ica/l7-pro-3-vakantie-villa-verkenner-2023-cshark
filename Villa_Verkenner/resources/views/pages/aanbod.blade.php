<x-layout title="Aanbod">
  <div class="aanbod-main">
    <div class="main-container-aanbod">
      <div class="search">
        <input type="text" placeholder="Zoek in Oostenrijk...">
        <button title="Search"><span>Bekijk Woningen</span><i class="fa-solid fa-location-dot"></i></button>
      </div>
      <div class="title-text">Huizen in Oostenrijk</div>
      <div class="filter-section">

      
        <div class="price-range">
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


        <div class="first-dropdown">
          <div class="dropdown"></div>
        </div>
        <div class="second-dropdown">
        <div class="dropdown"></div>
        </div>
      </div>
    </div>
  </div>
</x-layout>