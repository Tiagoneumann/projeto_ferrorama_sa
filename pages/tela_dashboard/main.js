const range = document.querySelector('input[type="range"]');

function setProgress(value) {
  range.value = value;
  range.style.setProperty('--progress', `${value}%`);
  range.nextElementSibling?.textContent = `${value}%`;
}
