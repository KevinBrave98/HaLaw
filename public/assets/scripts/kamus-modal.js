document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.istilah-item');
    items.forEach(item => {
        item.addEventListener('click', () => {
            const istilah = item.getAttribute('data-istilah');
            const arti = item.getAttribute('data-arti');
            document.getElementById('modalTitle').textContent = istilah;
            document.getElementById('modalArti').textContent = arti;
        });
    });
});
