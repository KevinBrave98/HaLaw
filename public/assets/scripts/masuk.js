const pilih_user = document.querySelector('#pilih_user')
const form = document.querySelector('#form_masuk')

pilih_user.addEventListener('change', (e) => {
    window.location.href = route(e.target.value)
})