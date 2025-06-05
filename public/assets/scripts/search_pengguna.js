const filter_icon = document.querySelector('#filter-icon')
const more_filter = document.querySelector('.more-filter');

filter_icon.addEventListener('click', () => {
  more_filter.classList.toggle('hide')
})

console.log("Aa")

const rangeInput = document.querySelectorAll(".range-input input")
const priceInput = document.querySelectorAll(".price-input input")
const range = document.querySelector(".slider .progress");
let priceGap = 10000;

window.onload = function(e) {
  priceInput.forEach((input) => {
    let minPrice = parseInt(priceInput[0].value),
      maxPrice = parseInt(priceInput[1].value);

     console.log(minPrice);
     console.log(maxPrice) 

    if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
      if (e.target.className === "input-min") {
        rangeInput[0].value = minPrice;
        range.style.left = ((minPrice-rangeInput[0].min) / (rangeInput[0].max-rangeInput[0].min)) * 100+ "%";
      } else {
        rangeInput[1].value = maxPrice;
        range.style.right = 100 - ((maxPrice-rangeInput[1].min) / (rangeInput[1].max-rangeInput[1].min)) * 100 + "%";
      }
    }
});

rangeInput.forEach((input) => {
    let minVal = parseInt(rangeInput[0].value),
      maxVal = parseInt(rangeInput[1].value);

    if (maxVal - minVal < priceGap) {
      if (e.target.className === "range-min") {
        rangeInput[0].value = maxVal - priceGap;
      } else {
        rangeInput[1].value = minVal + priceGap;
      }
    } else {
      priceInput[0].value = minVal;
      priceInput[1].value = maxVal;
       range.style.left = ((minVal-rangeInput[0].min) / (rangeInput[0].max-rangeInput[0].min)) * 100 + "%";
      range.style.right = 100 - ((maxVal-rangeInput[1].min) / (rangeInput[1].max-rangeInput[1].min)) * 100 + "%";
    }
});

}

priceInput.forEach((input) => {
  input.addEventListener("input", (e) => {
    let minPrice = parseInt(priceInput[0].value),
      maxPrice = parseInt(priceInput[1].value);

     console.log(minPrice);
     console.log(maxPrice) 

    if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
      if (e.target.className === "input-min") {
        rangeInput[0].value = minPrice;
        range.style.left = ((minPrice-rangeInput[0].min) / (rangeInput[0].max-rangeInput[0].min)) * 100+ "%";
      } else {
        rangeInput[1].value = maxPrice;
        range.style.right = 100 - ((maxPrice-rangeInput[1].min) / (rangeInput[1].max-rangeInput[1].min)) * 100 + "%";
      }
    }
  });
});

rangeInput.forEach((input) => {
  input.addEventListener("input", (e) => {
    let minVal = parseInt(rangeInput[0].value),
      maxVal = parseInt(rangeInput[1].value);

    if (maxVal - minVal < priceGap) {
      if (e.target.className === "range-min") {
        rangeInput[0].value = maxVal - priceGap;
      } else {
        rangeInput[1].value = minVal + priceGap;
      }
    } else {
      priceInput[0].value = minVal;
      priceInput[1].value = maxVal;
      range.style.left = ((minVal-rangeInput[0].min) / (rangeInput[0].max-rangeInput[0].min)) * 100 + "%";
      range.style.right = 100 - ((maxVal-rangeInput[1].min) / (rangeInput[1].max-rangeInput[1].min)) * 100 + "%";
    }
  });
});
