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

    // Dropdown toggling: when a dropdown is clicked, toggle its open state.
    document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
        toggle.addEventListener("click", (e) => {
            e.stopPropagation();
            const dropdownContent = toggle.nextElementSibling;
            dropdownContent.classList.toggle("open");
        });
    });

    document.addEventListener("click", function (e) {
        document.querySelectorAll(".dropdown-content.open").forEach((dropdownContent) => {
            if (!dropdownContent.contains(e.target) && 
                !dropdownContent.previousElementSibling.contains(e.target)) {
                dropdownContent.classList.remove("open");
                runFilters();
            }
        });
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