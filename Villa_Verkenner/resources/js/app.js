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

document.addEventListener('DOMContentLoaded', function() {
  console.log("DOM Content Loaded");
  
  // FILTER LOGIC
  const setupFilters = () => {
    let sliderOne = document.getElementById('slider-1');
    let sliderTwo = document.getElementById('slider-2');
    let displayValOne = document.getElementById('range1');
    let displayValTwo = document.getElementById('range2');
    let sliderTrack = document.querySelector('.slider-track');
    let sliderMaxValue = sliderOne ? parseInt(sliderOne.max) : 0;
    let minGap = 50000;
    let searchInput = document.querySelector('input[name="search"]');
    let currentOpenDropdown = null;
    
    // Skip if we're not on a page with filters
    if (!sliderOne) return;
    
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
    
    // The runFilters function sends an AJAX request with current filters.
    function runFilters() {
      console.log("runFilters triggered");
      const form = document.getElementById("filterForm");
      if (!form) return;

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
          if (cardContainer) {
            cardContainer.innerHTML = response.data.html;
          }
        })
        .catch(function (error) {
          if (error.response) {
            console.error("Error details:", error.response.data);
          } else {
            console.error(error);
          }
        });
    }

    // Create a debounced function for filtering
    window.debouncedRunFilters = debounce(runFilters, 500);

    if (searchInput) {
      searchInput.addEventListener("input", window.debouncedRunFilters);
    }

    // Add event listeners to all checkboxes in dropdowns
    document.querySelectorAll('.dropdown-content input[type="checkbox"]').forEach(checkbox => {
      checkbox.addEventListener('change', () => {
        window.debouncedRunFilters();
      });
    });

    // Prevent the form from submitting traditionally
    const filterForm = document.getElementById("filterForm");
    if (filterForm) {
      filterForm.addEventListener("submit", function (e) {
        e.preventDefault();
        runFilters();
      });
    }

    // Update UI continuously when dragging
    sliderOne.addEventListener("input", function () {
      displayValOne.textContent = formatCurrency(sliderOne.value);
      fillColor();
    });
    sliderTwo.addEventListener("input", function () {
      displayValTwo.textContent = formatCurrency(sliderTwo.value);
      fillColor();
    });

    // When slider is released, update UI and trigger filtering
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

    // Set initial display and fill colors
    displayValOne.textContent = formatCurrency(sliderOne.value);
    displayValTwo.textContent = formatCurrency(sliderTwo.value);
    fillColor();
    
    // Dropdown toggling
    document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
      toggle.addEventListener("click", (e) => {
        e.stopPropagation();
        const dropdownContent = toggle.nextElementSibling;
        
        // If another dropdown is open, close it first
        if (currentOpenDropdown && currentOpenDropdown !== dropdownContent && currentOpenDropdown.classList.contains('open')) {
          currentOpenDropdown.classList.remove('open');
          // Run filters when closing a dropdown
          window.debouncedRunFilters();
        }
        
        // Toggle the clicked dropdown
        dropdownContent.classList.toggle("open");
        
        // Update the reference to the currently open dropdown
        if (dropdownContent.classList.contains('open')) {
          currentOpenDropdown = dropdownContent;
        } else {
          currentOpenDropdown = null;
          // Run filters when closing a dropdown
          window.debouncedRunFilters();
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
        window.debouncedRunFilters();
      }
    });
  };

  // IMAGE SLIDER LOGIC
  const setupImageSlider = () => {
    console.log("Setting up image slider");
    
    const seeMoreBtn = document.getElementById('seeMoreBtnDetail');
    const sliderPopup = document.getElementById('imageSliderPopup');
    
    // Skip if we're not on a page with an image slider
    if (!seeMoreBtn || !sliderPopup) {
      console.log("Image slider elements not found, skipping setup");
      return;
    }
    
    const closePopupBtn = document.getElementById('closePopupBtn');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    const sliderImage = document.getElementById('sliderImage');
    
    console.log("Image slider elements:", {
      seeMoreBtn: !!seeMoreBtn,
      sliderPopup: !!sliderPopup,
      closePopupBtn: !!closePopupBtn,
      prevBtn: !!prevBtn,
      nextBtn: !!nextBtn,
      sliderImage: !!sliderImage
    });

    // Get images from the detail-main data attribute
    let images = [];
    const detailMain = document.querySelector('.detail-main');
    
    if (detailMain && detailMain.dataset.images) {
      try {
        images = JSON.parse(detailMain.dataset.images);
        console.log("Found images:", images.length);
      } catch (error) {
        console.error("Error parsing images:", error);
      }
    }
    
    if (images.length === 0) {
      console.warn("No images found, using fallback");
      images = [
        "https://picsum.photos/id/53/1200/700",
        "https://picsum.photos/id/22/2000",
        "https://picsum.photos/id/310/2000",
        "https://picsum.photos/id/237/1200/700",
        "https://picsum.photos/id/239/1200/700"
      ];
    }
    
    let currentSlide = 0;
    
    // Function to update the current slide
    function updateSlide() {
      if (!sliderImage || !images[currentSlide]) return;
      sliderImage.src = images[currentSlide];
      console.log("Showing image:", currentSlide, images[currentSlide]);
    }
    
    // Setup click event for the "See More" button
    seeMoreBtn.addEventListener('click', function() {
      console.log("See More button clicked");
      sliderPopup.style.display = 'flex';
      currentSlide = 0;
      updateSlide();
    });
    
    // Setup click event for the Close button
    if (closePopupBtn) {
      closePopupBtn.addEventListener('click', function() {
        console.log("Close button clicked");
        sliderPopup.style.display = 'none';
      });
    }
    
    // Setup click events for prev/next buttons
    if (prevBtn) {
      prevBtn.addEventListener('click', function() {
        console.log("Previous button clicked");
        currentSlide = (currentSlide > 0) ? currentSlide - 1 : images.length - 1;
        updateSlide();
      });
    }
    
    if (nextBtn) {
      nextBtn.addEventListener('click', function() {
        console.log("Next button clicked");
        currentSlide = (currentSlide < images.length - 1) ? currentSlide + 1 : 0;
        updateSlide();
      });
    }
  };
  
  // MORE INFO MODAL LOGIC
  const setupMoreInfoModal = () => {
    const moreInfoBtn = document.getElementById('moreInfoBtn');
    
    // Skip if we're not on a page with the More Info button
    if (!moreInfoBtn) return;
    
    console.log("Setting up More Info modal");
    
    moreInfoBtn.addEventListener('click', function() {
      console.log("More Info button clicked");
      const sendInfoModual = document.getElementById('sendInfoModual');
      if (!sendInfoModual) return;
      
      sendInfoModual.style.display = 'flex';
      
      const closeSendInfoBtn = document.getElementById('closeSendInfoBtn');
      if (closeSendInfoBtn) {
        closeSendInfoBtn.addEventListener('click', function() {
          sendInfoModual.style.display = 'none';
        });
      }
    });
  };
  
  // Initialize all components
  setupFilters();
  setupImageSlider();
  setupMoreInfoModal();
});