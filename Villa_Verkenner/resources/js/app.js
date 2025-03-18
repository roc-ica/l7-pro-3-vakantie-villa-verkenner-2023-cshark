import './bootstrap';
import Alpine from 'alpinejs';
import '../css/app.scss';
import axios from 'axios';

window.Alpine = Alpine;
Alpine.start();

// Debounce helper: waits "wait" milliseconds before executing the function
function debounce(func, wait, immediate) {
  let timeout;
  return function() {
    let context = this, args = arguments;
    let later = function() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    let callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
}

document.addEventListener('DOMContentLoaded', function() {
  let sliderOne = document.getElementById('slider-1');
  let sliderTwo = document.getElementById('slider-2');
  let displayValOne = document.getElementById('range1');
  let displayValTwo = document.getElementById('range2');
  let sliderTrack = document.querySelector('.slider-track');
  let sliderMaxValue = parseInt(sliderOne.max);
  let minGap = 50000;
  // Get the search input even if it's not inside the form
  let searchInput = document.querySelector('input[name="search"]');

  function formatCurrency(v) {
    return "€" + parseInt(v).toLocaleString('nl-NL');
  }

  window.slideOne = function() {
    if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
      sliderOne.value = parseInt(sliderTwo.value) - minGap;
    }
    displayValOne.textContent = formatCurrency(sliderOne.value);
    fillColor();
    runFilters();
  };

  window.slideTwo = function() {
    if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
      sliderTwo.value = parseInt(sliderOne.value) + minGap;
    }
    displayValTwo.textContent = formatCurrency(sliderTwo.value);
    fillColor();
    runFilters();
  };

  function fillColor() {
    let valueOne = parseInt(sliderOne.value);
    let valueTwo = parseInt(sliderTwo.value);
    let percentageOne = ((valueOne - sliderOne.min) / (sliderMaxValue - sliderOne.min)) * 100;
    let percentageTwo = ((valueTwo - sliderTwo.min) / (sliderMaxValue - sliderTwo.min)) * 100;
    sliderTrack.style.background = `linear-gradient(90deg, #d9d9d9 ${percentageOne}%, #345481 ${percentageOne}%, #345481 ${percentageTwo}%, #d9d9d9 ${percentageTwo}%)`;
  }

  displayValOne.textContent = formatCurrency(sliderOne.value);
  displayValTwo.textContent = formatCurrency(sliderTwo.value);
  fillColor();

  // Dropdown toggling
  document.querySelectorAll('.dropdown-toggle').forEach((toggle) => {
    toggle.addEventListener('click', () => {
      const dropdownContent = toggle.nextElementSibling;
      dropdownContent.classList.toggle('open');
    });
  });

  // Run filters via AJAX and update house cards
  function runFilters() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = {};
    // Collect filters from the form
    for (let pair of formData.entries()) {
      if (params[pair[0]]) {
        if (Array.isArray(params[pair[0]])) {
          params[pair[0]].push(pair[1]);
        } else {
          params[pair[0]] = [params[pair[0]], pair[1]];
        }
      } else {
        params[pair[0]] = pair[1];
      }
    }
    // Also include the search input value (outside the form)
    if (searchInput) {
      params.search = searchInput.value;
    }
    
    axios.get(form.action, {
      params: params,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(response) {
      const cardContainer = document.querySelector('.card-container');
      cardContainer.innerHTML = response.data.html;
    })
    .catch(function(error) {
      console.error(error);
    });
  }

  // Create a debounced function for search filtering (500ms delay)
  window.debouncedRunFilters = debounce(runFilters, 500);
});