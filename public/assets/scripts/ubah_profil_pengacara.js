//validasi
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('profileForm');
    const name = document.getElementById('namaLengkap');
    const email = document.getElementById('email');
    const phone = document.getElementById('nomorTelepon');
    const lokasi = document.getElementById('lokasi'); // pastikan id ini benar
    const tarifInput = document.getElementById('tarifJasa');

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

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Validasi nama
        if (name.value.trim() === '') {
            alert('Nama lengkap tidak boleh kosong.');
            name.focus();
            return;
        }

        // Validasi email
        if (email.value.trim() === '') {
            alert('Email tidak boleh kosong.');
            email.focus();
            return;
        }
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email.value.trim())) {
            alert('Email tidak valid.');
            email.focus();
            return;
        }

        // Validasi nomor telepon
        if (phone.value.trim() === '') {
            alert('Nomor telepon tidak boleh kosong.');
            phone.focus();
            return;
        }
        const phonePattern = /^\d{10,15}$/;
        if (!phonePattern.test(phone.value.trim())) {
            alert('Nomor telepon tidak valid. Harus terdiri dari 10 hingga 15 digit.');
            phone.focus();
            return;
        }

        // Validasi lokasi kerja
        if (lokasi.value.trim() === '') {
            alert('Lokasi tempat kerja tidak boleh kosong.');
            lokasi.focus();
            return;
        }

        // Validasi pengalaman (semua input .input-pengalaman tidak boleh kosong)
        const pengalamanInputs = document.querySelectorAll('.input-pengalaman');
        for (let input of pengalamanInputs) {
            if (input.value.trim() === '') {
                alert('Pengalaman kerja tidak boleh kosong.');
                input.focus();
                return;
            }
        }

        // Jika semua validasi lolos, submit form
        form.submit();
    });
});

    