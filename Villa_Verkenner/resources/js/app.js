import './bootstrap';

import Alpine from 'alpinejs';

import '../css/app.scss';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function() {
  let sliderOne = document.getElementById('slider-1');
  let sliderTwo = document.getElementById('slider-2');
  let displayValOne = document.getElementById('range1');
  let displayValTwo = document.getElementById('range2');
  let sliderTrack = document.querySelector('.slider-track');
  let sliderMaxValue = parseInt(sliderOne.max);
  let minGap = 50000;

  function formatCurrency(v) {
    return "€" + parseInt(v).toLocaleString('nl-NL');
  }

  window.slideOne = function() {
    if(parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
      sliderOne.value = parseInt(sliderTwo.value) - minGap;
    }
    displayValOne.textContent = formatCurrency(sliderOne.value);
    fillColor();
  }

  window.slideTwo = function() {
    if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
      sliderTwo.value = parseInt(sliderOne.value) + minGap;
    }
    displayValTwo.textContent = formatCurrency(sliderTwo.value);
    fillColor();
  }

  function fillColor() {
    let valueOne = parseInt(sliderOne.value);
    let valueTwo = parseInt(sliderTwo.value);
    let percentageOne = ((valueOne - sliderOne.min) / (sliderMaxValue - sliderOne.min)) * 100;
    let percentageTwo = ((valueTwo - sliderTwo.min) / (sliderMaxValue - sliderTwo.min)) * 100;
  
    console.log(`Slider One Value: ${valueOne}, Percentage: ${percentageOne}%`);
    console.log(`Slider Two Value: ${valueTwo}, Percentage: ${percentageTwo}%`);
  
    sliderTrack.style.background = `linear-gradient(90deg, #d9d9d9 ${percentageOne}%, #345481 ${percentageOne}%, #345481 ${percentageTwo}%, #d9d9d9 ${percentageTwo}%)`;
  }

  displayValOne.textContent = formatCurrency(sliderOne.value);
  displayValTwo.textContent = formatCurrency(sliderTwo.value);
  fillColor();
});