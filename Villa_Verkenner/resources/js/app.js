import "./bootstrap";
import Alpine from "alpinejs";
import "../css/app.scss";
import axios from "axios";

window.Alpine = Alpine;
Alpine.start();

// Complete Debounce helper: waits "wait" milliseconds before executing the function
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
    let sliderOne = document.getElementById("slider-1");
    let sliderTwo = document.getElementById("slider-2");
    let displayValOne = document.getElementById("range1");
    let displayValTwo = document.getElementById("range2");
    let sliderTrack = document.querySelector(".slider-track");
    let sliderMaxValue = parseInt(sliderOne.max);
    let minGap = 50000;
    // Get the search input (it's outside the form)
    let searchInput = document.querySelector('input[name="search"]');

    // Create a debounced function for filtering (500ms delay)
    window.debouncedRunFilters = debounce(runFilters, 500);

    if (searchInput) {
        // Update filters dynamically on each keystroke
        searchInput.addEventListener("input", debouncedRunFilters);
    }

    // Prevent the form from submitting traditionally so AJAX always takes over (avoid Enter issues)
    const filterForm = document.getElementById("filterForm");
    filterForm.addEventListener("submit", function (e) {
        e.preventDefault();
        runFilters();
    });

    function formatCurrency(v) {
        return "€" + parseInt(v).toLocaleString("nl-NL");
    }

    window.slideOne = function () {
        if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
            sliderOne.value = parseInt(sliderTwo.value) - minGap;
        }
        displayValOne.textContent = formatCurrency(sliderOne.value);
        fillColor();
        runFilters();
    };

    window.slideTwo = function () {
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
        let percentageOne =
            ((valueOne - sliderOne.min) / (sliderMaxValue - sliderOne.min)) *
            100;
        let percentageTwo =
            ((valueTwo - sliderTwo.min) / (sliderMaxValue - sliderTwo.min)) *
            100;
        sliderTrack.style.background = `linear-gradient(90deg, #d9d9d9 ${percentageOne}%, #345481 ${percentageOne}%, #345481 ${percentageTwo}%, #d9d9d9 ${percentageTwo}%)`;
    }

    displayValOne.textContent = formatCurrency(sliderOne.value);
    displayValTwo.textContent = formatCurrency(sliderTwo.value);
    fillColor();

    // Dropdown toggling: when closing a dropdown, update the filters.
    document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
        toggle.addEventListener("click", () => {
            const dropdownContent = toggle.nextElementSibling;
            const wasOpen = dropdownContent.classList.contains("open");
            dropdownContent.classList.toggle("open");
            // If the dropdown was open and now closed, update filters.
            if (wasOpen) {
                runFilters();
            }
        });
    });

    // Run filters via AJAX and update house cards
    function runFilters() {
        console.log("runFilters triggered");
        const form = document.getElementById("filterForm");
        const formData = new FormData(form);
        const params = {};

        // Remove square brackets from keys if present so Laravel can detect them
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
        // Also include the search input value (from outside the form)
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            params.search = searchInput.value;
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
