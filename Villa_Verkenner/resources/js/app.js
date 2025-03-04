import './bootstrap';

import Alpine from 'alpinejs';

import '../css/app.scss';

window.Alpine = Alpine;

Alpine.start();

const minPrice = document.getElementById('min-price');
const maxPrice = document.getElementById('max-price');
const euroSign = "€ ";

minPrice.addEventListener('focus', () => {
  if (!minPrice.value.includes(euroSign)) {
    minPrice.value = euroSign;
  }
});

minPrice.addEventListener('blur', () => {
  if (minPrice.value === euroSign) {
    minPrice.value = "";
  }
});

maxPrice.addEventListener('focus', () => {
  if (!maxPrice.value.includes(euroSign)) {
    maxPrice.value = euroSign;
  }
});

maxPrice.addEventListener('blur', () => {
  if (maxPrice.value === euroSign) {
    maxPrice.value = "";
  }
});

const allowOnlyNumbers = (e) => {
  const input = e.target;
  input.value = euroSign + input.value.replace(/[^0-9]/g, '').replace(euroSign, '');
};

minPrice.addEventListener('input', allowOnlyNumbers);
maxPrice.addEventListener('input', allowOnlyNumbers);