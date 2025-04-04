import './bootstrap';

import Alpine from 'alpinejs';

import '../css/app.scss';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function() {
  const dropdown = document.querySelectorAll('.dropdown');
  const dropdownToggle = document.querySelectorAll('.dropdown-toggle');
  const dropdownContent = document.querySelectorAll('.dropdown-content');
  let sliderOne = document.getElementById('slider-1');
  let sliderTwo = document.getElementById('slider-2');
  let displayValOne = document.getElementById('range1');
  let displayValTwo = document.getElementById('range2');
  let sliderTrack = document.querySelector('.slider-track');
  let sliderMaxValue = sliderOne ? parseInt(sliderOne.max) : 0;
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
  
    sliderTrack.style.background = `linear-gradient(90deg, #d9d9d9 ${percentageOne}%, #345481 ${percentageOne}%, #345481 ${percentageTwo}%, #d9d9d9 ${percentageTwo}%)`;
  }

  if (displayValOne && displayValTwo) {
    displayValOne.textContent = formatCurrency(sliderOne.value);
    displayValTwo.textContent = formatCurrency(sliderTwo.value);
    fillColor();
  }

  // dropdowns
  dropdownToggle.forEach((toggle, index) => {
    toggle.addEventListener('click', () => {
      const content = dropdownContent[index];
      const dropdown = toggle.parentElement;
      if (content.style.display === 'block') {
        content.style.display = 'none';
        content.style.borderRadius = '5px';
        dropdown.style.borderRadius = '45px';
      } else {
        content.style.display = 'block';
        content.style.borderRadius = '0 0 5px 5px';
        dropdown.style.borderRadius = `${45 / 2}px ${45 / 2}px 0 0`;
      }
    });
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