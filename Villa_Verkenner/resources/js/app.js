import './bootstrap';

import Alpine from 'alpinejs';

import '../css/app.scss';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
  const slider = document.querySelector(".slider");
  const thumbLeft = document.querySelector(".thumb-left");
  const thumbRight = document.querySelector(".thumb-right");
  const filledPart = document.querySelector(".filled-part");

  let min = 0;
  let max = 100;
  let leftValue = 25;
  let rightValue = 75;
  let activeThumb = null;

  function updateUI() {
      let leftPercent = ((leftValue - min) / (max - min)) * 100;
      let rightPercent = ((rightValue - min) / (max - min)) * 100;

      thumbLeft.style.left = `${leftPercent}%`;
      thumbRight.style.left = `${rightPercent}%`;
      filledPart.style.left = `${leftPercent}%`;
      filledPart.style.width = `${rightPercent - leftPercent}%`;
  }

  function setLeftValue(value) {
      leftValue = Math.min(Math.max(min, value), rightValue - 1);
      updateUI();
  }

  function setRightValue(value) {
      rightValue = Math.max(Math.min(max, value), leftValue + 1);
      updateUI();
  }

  function onMouseMove(event) {
      if (!activeThumb) return;
      let rect = slider.getBoundingClientRect();
      let percent = ((event.clientX - rect.left) / rect.width) * (max - min) + min;

      if (activeThumb === thumbLeft) {
          setLeftValue(percent);
      } else if (activeThumb === thumbRight) {
          setRightValue(percent);
      }
  }

  function onMouseDown(event) {
      activeThumb = event.target;
      document.addEventListener("mousemove", onMouseMove);
      document.addEventListener("mouseup", onMouseUp);
  }

  function onMouseUp() {
      activeThumb = null;
      document.removeEventListener("mousemove", onMouseMove);
      document.removeEventListener("mouseup", onMouseUp);
  }

  thumbLeft.addEventListener("mousedown", onMouseDown);
  thumbRight.addEventListener("mousedown", onMouseDown);
  updateUI();
});