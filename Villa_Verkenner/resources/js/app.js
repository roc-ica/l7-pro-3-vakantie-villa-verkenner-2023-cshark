import "./bootstrap";
import Alpine from "alpinejs";
import "../css/app.scss";
import axios from "axios";

window.Alpine = Alpine;
Alpine.start();

// Debounce helper: waits "wait" milliseconds before executing the function
function debounce(func, wait, immediate) {
    let timeout;
    return function () {
        const context = this,
            args = arguments;
        const later = function () {
            timeout = null;
            if (!immediate) {
                func.apply(context, args);
            }
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) {
            func.apply(context, args);
        }
    };
}

document.addEventListener("DOMContentLoaded", function () {
    // Get slider elements and related DOM nodes.
    let sliderOne = document.getElementById("slider-1");
    let sliderTwo = document.getElementById("slider-2");
    let displayValOne = document.getElementById("range1");
    let displayValTwo = document.getElementById("range2");
    let sliderTrack = document.querySelector(".slider-track");
    let sliderMaxValue = parseInt(sliderOne.max);
    let minGap = 50000;
    // Get the search input (outside the form)
    let searchInput = document.querySelector('input[name="search"]');

    // Create a debounced function for filtering (500ms delay)
    window.debouncedRunFilters = debounce(runFilters, 500);

    if (searchInput) {
        // Update filters dynamically on keystrokes (debounced)
        searchInput.addEventListener("input", debouncedRunFilters);
    }

    // Add event listeners to all checkboxes in dropdowns
    document.querySelectorAll('.dropdown-content input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            // Run filters without closing the dropdown
            debouncedRunFilters();
        });
    });

    // Prevent the form from submitting traditionally so AJAX always takes over.
    const filterForm = document.getElementById("filterForm");
    filterForm.addEventListener("submit", function (e) {
        e.preventDefault();
        runFilters();
    });

    // Formats a value as Dutch currency.
    function formatCurrency(v) {
        return "€" + parseInt(v).toLocaleString("nl-NL");
    }

    // Update the slider track's fill color.
    function fillColor() {
        let valueOne = parseInt(sliderOne.value);
        let valueTwo = parseInt(sliderTwo.value);
        let percentageOne = ((valueOne - sliderOne.min) / (sliderMaxValue - sliderOne.min)) * 100;
        let percentageTwo = ((valueTwo - sliderTwo.min) / (sliderMaxValue - sliderTwo.min)) * 100;
        sliderTrack.style.background = `linear-gradient(90deg, #d9d9d9 ${percentageOne}%, #345481 ${percentageOne}%, #345481 ${percentageTwo}%, #d9d9d9 ${percentageTwo}%)`;
    }

    // Update UI continuously when dragging (without triggering filter).
    sliderOne.addEventListener("input", function () {
        displayValOne.textContent = formatCurrency(sliderOne.value);
        fillColor();
    });
    sliderTwo.addEventListener("input", function () {
        displayValTwo.textContent = formatCurrency(sliderTwo.value);
        fillColor();
    });

    // When slider is released, update UI and trigger filtering.
    sliderOne.addEventListener("change", function () {
        displayValOne.textContent = formatCurrency(sliderOne.value);
        fillColor();
        runFilters();
    });
    sliderTwo.addEventListener("change", function () {
        displayValTwo.textContent = formatCurrency(sliderTwo.value);
        fillColor();
        runFilters();
    });

    // Set initial display and fill colors.
    displayValOne.textContent = formatCurrency(sliderOne.value);
    displayValTwo.textContent = formatCurrency(sliderTwo.value);
    fillColor();

    // Track the currently open dropdown
    let currentOpenDropdown = null;

    // Dropdown toggling: when a dropdown is clicked, toggle its open state.
    document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
        toggle.addEventListener("click", (e) => {
            e.stopPropagation();
            const dropdownContent = toggle.nextElementSibling;
            
            // If another dropdown is open, close it first
            if (currentOpenDropdown && currentOpenDropdown !== dropdownContent && currentOpenDropdown.classList.contains('open')) {
                currentOpenDropdown.classList.remove('open');
                // Run filters when closing a dropdown
                debouncedRunFilters();
            }
            
            // Toggle the clicked dropdown
            dropdownContent.classList.toggle("open");
            
            // Update the reference to the currently open dropdown
            if (dropdownContent.classList.contains('open')) {
                currentOpenDropdown = dropdownContent;
            } else {
                currentOpenDropdown = null;
                // Run filters when closing a dropdown
                debouncedRunFilters();
            }
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (e) {
        let shouldRunFilters = false;
        
        document.querySelectorAll(".dropdown-content.open").forEach((dropdownContent) => {
            if (!dropdownContent.contains(e.target) && 
                !dropdownContent.previousElementSibling.contains(e.target)) {
                dropdownContent.classList.remove("open");
                shouldRunFilters = true;
                currentOpenDropdown = null;
            }
        });
        
        // Only run filters once if any dropdown was closed
        if (shouldRunFilters) {
            debouncedRunFilters();
        }
    });

    // The runFilters function sends an AJAX request with current filters.
    function runFilters() {
        console.log("runFilters triggered");
        const form = document.getElementById("filterForm");
        const formData = new FormData(form);
        const params = {};
        for (let pair of formData.entries()) {
            let key = pair[0].replace("[]", "");
            if (params[key]) {
                if (Array.isArray(params[key])) {
                    params[key].push(pair[1]);
                } else {
                    params[key] = [params[key], pair[1]];
                }
            } else {
                params[key] = pair[1];
            }
        }
        params.min_price = sliderOne.value;
        params.max_price = sliderTwo.value;
        const externalSearchInput = document.querySelector('input[name="search"]');
        if (externalSearchInput) {
            params.search = externalSearchInput.value;
        }

        console.log("Search params:", params);

        axios
            .get(form.action, {
                params: params,
                headers: { "X-Requested-With": "XMLHttpRequest" },
            })
            .then(function (response) {
                const cardContainer = document.querySelector(".card-container");
                cardContainer.innerHTML = response.data.html;
            })
            .catch(function (error) {
                if (error.response) {
                    console.error("Error details:", error.response.data);
                } else {
                    console.error(error);
                }
            });
    }
  });

// Image slider popup
const seeMoreBtn = document.getElementById('seeMoreBtnDetail');
const sliderPopup = document.getElementById('imageSliderPopup');
const closePopupBtn = document.getElementById('closePopupBtn');

// Get images from the detail-main data attribute
let images = [];

// Try to find images from the detail-main element
const detailMain = document.querySelector('.detail-main');
console.log('Detail main element found:', detailMain);

if (detailMain && detailMain.dataset.images) {
  console.log('Data images attribute found:', detailMain.dataset.images);
  try {
    images = JSON.parse(detailMain.dataset.images);
    console.log('Parsed images array:', images);
  } catch (error) {
    console.error('Error parsing images data attribute:', error);
  }
} else {
  console.warn('No data-images attribute found on .detail-main element');
}

if (images.length === 0) {
  // Fallback: hardcoded images
  console.log('Using fallback image array');
  images = [
    "https://picsum.photos/id/53/1200/700",
    "https://picsum.photos/id/22/2000",
    "https://picsum.photos/id/310/2000",
    "https://picsum.photos/id/237/1200/700",
    "https://picsum.photos/id/239/1200/700"
  ];
}

console.log('Final images array:', images);

let currentSlide = 0;
const prevBtn = document.getElementById('prevSlide');
const nextBtn = document.getElementById('nextSlide');
const sliderImage = document.getElementById('sliderImage');

console.log('Slider elements found:', {
  seeMoreBtn: !!seeMoreBtn,
  sliderPopup: !!sliderPopup,
  closePopupBtn: !!closePopupBtn,
  prevBtn: !!prevBtn,
  nextBtn: !!nextBtn,
  sliderImage: !!sliderImage
});

if (seeMoreBtn) {
  seeMoreBtn.addEventListener('click', function() {
    console.log('See more button clicked');
    if (sliderPopup) {
      sliderPopup.style.display = 'flex';
      
      // Initialize with first image when opening
      if (sliderImage && images.length > 0) {
        currentSlide = 0;
        sliderImage.src = images[currentSlide];
        console.log('Set initial slide image:', images[currentSlide]);
      }
    }
  });
}

if (closePopupBtn) {
  closePopupBtn.addEventListener('click', function() {
    console.log('Close button clicked');
    if (sliderPopup) {
      sliderPopup.style.display = 'none';
    }
  });
}

// Image slider functionality
if (prevBtn && nextBtn && sliderImage && images.length > 0) {
  function updateSlide() {
    sliderImage.src = images[currentSlide];
    console.log('Updated slide to index', currentSlide, 'with image:', images[currentSlide]);
  }
  
  prevBtn.addEventListener('click', function() {
    console.log('Previous button clicked');
    currentSlide = (currentSlide > 0) ? currentSlide - 1 : images.length - 1;
    updateSlide();
  });
  
  nextBtn.addEventListener('click', function() {
    console.log('Next button clicked');
    currentSlide = (currentSlide < images.length - 1) ? currentSlide + 1 : 0;
    updateSlide();
  });
  
  // Initialize with first image
  updateSlide();
}
});

document.getElementById('moreInfoBtn').addEventListener('click', function() {
  const sendInfoModual = document.getElementById('sendInfoModual');
  const closeSendInfoBtn = document.getElementById('closeSendInfoBtn');
  sendInfoModual.style.display = 'flex';
  closeSendInfoBtn.addEventListener('click', function() {
    sendInfoModual.style.display = 'none';
  });
})