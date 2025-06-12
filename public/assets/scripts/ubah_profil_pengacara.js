//validasi
document.addEventListener('DOMContentLoaded', function () {
    const durasiInput = document.getElementById('durasi');
    const tarifInput = document.getElementById('tarifJasa');
    const input = document.getElementById('input-foto');
    const preview = document.getElementById('preview-foto');

     // Simpan angka saja saat mengetik
    durasiInput.addEventListener('input', function () {
        let value = durasiInput.value.replace(/[^0-9]/g, '');
        durasiInput.value = value;
    });

    // Tambahkan " Tahun" saat blur (selesai mengetik)
    durasiInput.addEventListener('blur', function () {
        let value = durasiInput.value.replace(/[^0-9]/g, '');
        if (value) {
            durasiInput.value = value + ' Tahun';
        }
    });

    // Jika value sudah ada saat load
    if (durasiInput.value) {
        let val = durasiInput.value.replace(/[^0-9]/g, '');
        durasiInput.value = val ? val + ' Tahun' : '';
    }


    // Pasang event listener input tarif jasa di sini, agar aktif sepanjang waktu
    tarifInput.addEventListener('input', function(e) {
        let value = tarifInput.value;
        value = value.replace(/[^0-9]/g, '');
        if (value) {
            value = new Intl.NumberFormat('id-ID').format(value);
            tarifInput.value = 'Rp' + value;
        } else {
            tarifInput.value = '';
        }
    });

    // Format awal tarif jika sudah ada value
    if (tarifInput.value) {
        let val = tarifInput.value.replace(/[^0-9]/g, '');
        tarifInput.value = val ? 'Rp' + new Intl.NumberFormat('id-ID').format(val) : '';
    }

    // Event listener untuk input foto
    input.addEventListener('change', function(event) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    });
});

