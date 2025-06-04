let filter_icon = document.querySelector('#filter-icon')
let more_filter = document.querySelector('.more-filter');

filter_icon.addEventListener('click', () => {
    more_filter.classList.toggle('hide')
})