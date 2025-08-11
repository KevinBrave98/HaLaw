<?php

namespace Database\Seeders;

use App\Models\Kamus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KamusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kamus::truncate();

        Kamus::create([
            'istilah'=>'Abolisi',
            'arti_istilah'=>'Penghapusan tuntutan oleh Presiden kepada seseorang atau sekelompok orang yang melakukan tindak pidana'
        ]);
        Kamus::create([
            'istilah'=>'Accessoir',
            'arti_istilah'=>'Perjanjian tambahan yang berlaku dan sah sesuai perjanjian pokok'
        ]);
        Kamus::create([
            'istilah'=>'Actio Popularis',
            'arti_istilah'=>
            'Prosedur pengajuan gugatan yang melibatkan kepentingan umum secara perwakilan (Citizen Law Suit)'        
        ]);
        Kamus::create([
            'istilah'=>'Ad hoc',
            'arti_istilah'=>
            'Sesuatu yang ditetapkan atau seseorang yang ditunjuk untuk tujuan atau jangka waktu tertentu'        
        ]);        
        Kamus::create([
            'istilah'=>'Adat',
            'arti_istilah'=>'aturan atau norma tidak tertulis yang hidup dalam masyarakat hukum adat yang mengatur, mengikat dan dipertahankan, serta mempunyai sanksi'
        ]);
        Kamus::create([
            'istilah'=>'Administrasi Hukum Umum Online',
            'arti_istilah'=>'sistem pelayanan publik berbasis elektronik yang diselenggarakan oleh Direktorat Jenderal Administrasi Hukum Umum'
        ]);
        Kamus::create([
            'istilah'=>'Agunan',
            'arti_istilah'=>
            'Jaminan tambahan yang diserahkan nasabah debitur dalam rangka pemberian fasilitas kredit atau pembiayaan'        
        ]);
        Kamus::create([
            'istilah'=>'Akta di bawah tangan',
            'arti_istilah'=>
            'Akta yang hanya dibuat antara para pihak tanpa disaksikan atau penandatangan pejabat berwenang (Notaris)'        
        ]);
        Kamus::create([
            'istilah'=>'Akta Otentik',
            'arti_istilah'=>
            'Akta yang dibuat oleh atau di hadapan pejabat umum yang berwenang membuat akta (Notaris, PPAT, Camat) dan memiliki kekuatan pembuktian penuh dibandingkan akta biasa'        
        ]);
        Kamus::create([
            'istilah'=>'Amandemen',
            'arti_istilah'=>
            'Perubahan baik dengan cara penambahan, pencabutan, atau penggantian ketentuan yang sudah ada dalam peraturan perundang-undangan'        
        ]);
        Kamus::create([
            'istilah'=>'Amar',
            'arti_istilah'=>
            'Pokok suatu putusan pengadilan, yaitu setelah kata-kata memutuskan atau mengadili'        
        ]);
        Kamus::create([
            'istilah'=>'Amdal',
            'arti_istilah'=>
            'Kajian mengenai dampak besar dan penting suatu usaha dan/atau kegiatan yang direncanakan pada lingkungan hidup'        
        ]);
        Kamus::create([
            'istilah'=>'Amnesti',
            'arti_istilah'=>
            'Penghapusan hukuman yang diberikan oleh Presiden kepada seseorang atau sekelompok orang yang melakukan tindak pidana tertentu'        
        ]);
        Kamus::create([
            'istilah'=>'Anjak piutang (Factoring)',
            'arti_istilah'=>
            'Penjualan atau pengalihan piutang-piutang dagang suatu perusahaan kepada pihak lain (perusahaan anjak piutang) yang melakukan penagihan piutang tersebut'        
        ]);
        Kamus::create([
            'istilah'=>'Asas Legalitas',
            'arti_istilah'=>
            'Tidak ada tindak pidana jika belum ada undang-undang yang mengaturnya lebih dahulu'        
        ]);
        Kamus::create([
            'istilah'=>'Arbitrase',
            'arti_istilah'=>
            'Penyelesaian sengketa bidang hukum perdata di luar lembaga peradilan umum yang didasarkan pada perjanjian arbitrase yang dibuat secara tertulis oleh para pihak yang bersengketa'        
        ]);
        Kamus::create([
            'istilah'=>'Badan Hukum',
            'arti_istilah'=>
            'Badan atau organisasi yang oleh hukum diperlakukan sebagai orang'        
        ]);
        Kamus::create([
            'istilah'=>'Banding',
            'arti_istilah'=>
            'Hak terdakwa atau jaksa penuntut umum untuk memohon agar putusan Pengadilan Negeri diperiksa kembali oleh Pengadilan Tinggi'        
        ]);
        Kamus::create([
            'istilah'=>'Batal demi hukum',
            'arti_istilah'=>
            'Kebatalan yang berdasarkan undang-undang bersifat otomatis tanpa memerlukan pernyataan hakim'        
        ]);
        Kamus::create([
            'istilah'=>'Berita Acara Pemeriksaan',
            'arti_istilah'=>
            'Laporan hasil pemeriksaan terhadap tersangka, saksi-saksi, surat, dan barang bukti lainnya dalam pemeriksaan suatu tindak pidana'        
        ]);
        Kamus::create([
            'istilah'=>'BPN',
            'arti_istilah'=>
            'Badan Pertanahan Nasional – lembaga yang berwenang mengeluarkan tanda bukti hak atas tanah'        
        ]);
        Kamus::create([
            'istilah'=>'Buku Tanah',
            'arti_istilah'=>
            'Buku yang berfungsi sebagai tanda bukti hak atas tanah'        
        ]);
        Kamus::create([
            'istilah'=>'Buruh Migran',
            'arti_istilah'=>
            'Seseorang yang akan, sedang, atau telah melakukan pekerjaan yang dibayar di luar negeri'        
        ]);
        Kamus::create([
            'istilah'=>'Cakap',
            'arti_istilah'=>
            'Orang yang sudah dewasa, sehat akal pikiran dan tidak dilarang oleh peraturan perundang-undangan'        
        ]);
        Kamus::create([
            'istilah'=>'Cessie',
            'arti_istilah'=>
            'Pemindahan atau pengalihan piutang-piutang atas nama dari kreditur lama kepada kreditur baru'        
        ]);
        Kamus::create([
            'istilah'=>'Citizen Law Suit',
            'arti_istilah'=>
            'Hak Gugat Warganegara'        
        ]);
        Kamus::create([
            'istilah'=>'Class Action',
            'arti_istilah'=>
            'Suatu cara pengajuan gugatan, di mana satu orang atau lebih mewakili kelompok mengajukan gugatan untuk dirinya sendiri dan kelompoknya'        
        ]); 
        Kamus::create([
            'istilah'=>'Dakwaan',
            'arti_istilah'=>
            'Tuduhan formal dan tertulis yang diajukan oleh penuntut di pengadilan terhadap terdakwa'        
        ]);
        Kamus::create([
            'istilah'=>'Droit de suite',
            'arti_istilah'=>
            'Hak kebendaan seseorang untuk mempertahankan atau mengikuti benda tersebut di tangan siapa pun benda itu berada'        
        ]); 
        Kamus::create([
            'istilah'=>'Dapat dibatalkan',
            'arti_istilah'=>
            'Suatu perbuatan hukum yang memenuhi syarat pembatalan, tetapi sebelum dibatalkan tetap sah'        
        ]);
        Kamus::create([
            'istilah'=>'Debitur',
            'arti_istilah'=>
            'Individu maupun badan hukum yang memiliki kewajiban kepada kreditur'        
        ]); 
        Kamus::create([
            'istilah'=>'Duplik',
            'arti_istilah'=>
            'Jawaban tergugat terhadap replik penggugat dalam perkara perdata'        
        ]); 
        Kamus::create([
            'istilah'=>'Eksekusi',
            'arti_istilah'=>
            'Pelaksanaan putusan pengadilan'        
        ]);
        Kamus::create([
            'istilah'=>'Eksekusi Hak Tanggungan',
            'arti_istilah'=>
            'Tindakan dari kreditur untuk mengambil pelunasan utang dengan menjual hak atas yang dibebani hak tanggungan'        
        ]);
        Kamus::create([
            'istilah'=>'Eksploitasi',
            'arti_istilah'=>
            'Rangkaian kegiatan pada Wilayah Kerja tertentu yang meliputi pengeboran sumur pengembangan dan sumur reinjeksi, pembangunan fasilitas lapangan dan penunjangnya, serta operasi produksi Panas Bumi.'        
        ]); 
        Kamus::create([
            'istilah'=>'Eksploitasi Seksual',
            'arti_istilah'=>
            'Segala bentuk pemanfaatan organ tubuh seksual atau organ tubuh lain dari korban untuk mendapatkan keuntungan, termasuk tetapi tidak terbatas pada semua kegiatan pelacuran dan percabulan'        
        ]); 
        Kamus::create([
            'istilah'=>'Ex-officio',
            'arti_istilah'=>
            'Jabatan seseorang pada lembaga tertentu karena tugas dan kewenangannya pada lembaga lain.'        
        ]);
        Kamus::create([
            'istilah'=>'Faktur Pajak',
            'arti_istilah'=>
            'bukti pungutan pajak yang dibuat oleh Pengusaha Kena Pajak yang melakukan penyerahan Barang Kena Pajak atau penyerahan Jasa Kena Pajak'        
        ]);
        Kamus::create([
            'istilah'=>'Federasi Serikat Buruh',
            'arti_istilah'=>
            'Gabungan dari sekurang-kurangnya 5 serikat buruh'        
        ]);
        Kamus::create([
            'istilah'=>'Fidusia',
            'arti_istilah'=>
            'Pengalihan hak kepemilikan suatu benda atas dasar kepercayaan'        
        ]); 
        Kamus::create([
            'istilah'=>'Financial Leasing',
            'arti_istilah'=>
            'Jenis leasing di mana di akhir masa leasing diberikan hak pilih untuk membeli barang modal'        
        ]);
        Kamus::create([
            'istilah'=>'Forkopimda',
            'arti_istilah'=>
            'forum yang digunakan untuk membahas penyelenggaraan urusan pemerintahan umum'        
        ]);
        Kamus::create([
            'istilah'=>'Genosida',
            'arti_istilah'=>
            'Setiap perbuatan yang dilakukan dengan tujuan untuk memusnahkan seluruh atau sebagian kelompok bangsa, ras, etnis, agama, dengan cara membunuh anggota kelompok, menciptakan kondisi yang mengakibatkan kemusnahan fisik, memaksakan langkah-langkah pencegahan kelahiran, atau memindahkan anak-anak secara paksa ke kelompok lain'        
        ]);
        Kamus::create([
            'istilah'=>'Grasi',
            'arti_istilah'=>
            'Pengampunan berupa pengurangan, perubahan, atau penghapusan pelaksanaan pidana kepada terpidana yang diberikan oleh Presiden'        
        ]);
        Kamus::create([
            'istilah'=>'Gratifikasi',
            'arti_istilah'=>
            'Pemberian dalam arti luas, meliputi pemberian uang, barang, diskon, komisi, pinjaman tanpa bunga, tiket perjalanan, fasilitas penginapan, perjalanan wisata, pengobatan cuma-cuma, dan fasilitas lainnya'        
        ]);
        Kamus::create([
            'istilah'=>'Grosse Akta',
            'arti_istilah'=>
            'Salinan resmi akta otentik yang mempunyai kekuatan eksekutorial'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Milik Atas Satuan Rumah Susun',
            'arti_istilah'=>
            'Hak milik atas unit tempat tinggal yang terpisah dengan bagian bersama, benda bersama, dan tanah bersama'        
        ]);
        Kamus::create([
            'istilah'=>'Hak atas Tanah',
            'arti_istilah'=>
            'Hak untuk menguasai tanah yang diberikan kepada perorangan atau badan hukum'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Gugat Organisasi',
            'arti_istilah'=>
            'Legal Standing'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Gugat Warganegara',
            'arti_istilah'=>
            'Orang atau organisasi warga negara untuk kepentingan keseluruhan warga negara'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Guna Bangunan',
            'arti_istilah'=>
            'Hak untuk mendirikan dan mempunyai bangunan di atas tanah'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Guna Usaha',
            'arti_istilah'=>
            'Hak yang diberikan untuk usaha pertanian, perikanan, peternakan'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Milik',
            'arti_istilah'=>
            'Hak turun-temurun, terkuat, dan terpenuh'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Normatif Buruh',
            'arti_istilah'=>
            'Hak dasar buruh dalam peraturan perundangan'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Pakai',
            'arti_istilah'=>
            'Hak menggunakan atau memungut hasil dari tanah'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Preferen',
            'arti_istilah'=>
            'Hak didahulukan dari kreditur lain'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Tanggungan',
            'arti_istilah'=>
            'Hak jaminan atas tanah berikut benda-benda di atasnya untuk pelunasan utang'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Uji Formil',
            'arti_istilah'=>
            'Hak menguji apakah suatu peraturan sudah sesuai prosedur'        
        ]);
        Kamus::create([
            'istilah'=>'Hak Uji Materiil',
            'arti_istilah'=>
            'Hak menguji isi peraturan bertentangan dengan aturan yang lebih tinggi'        
        ]);
        Kamus::create([
            'istilah'=>'Hakim',
            'arti_istilah'=>
            'hakim pada badan peradilan yang berada dibawah Mahkamah Agung dalam lingkungan peradilan umum, lingkungan peradilan agama, lingkungan peradilan militer, dan lingkungan peradilan tata usaha negara.'        
        ]);
        Kamus::create([
            'istilah'=>'Hakim ad hoc',
            'arti_istilah'=>
            'seseorang yang diangkat berdasarkan persyaratan yang ditentukan dalam Undang-Undang ini sebagai hakim tindak pidana korupsi.'        
        ]);
        Kamus::create([
            'istilah'=>'Hakim Anggota',
            'arti_istilah'=>
            'Hakim dalam suatu Majelis yang ditunjuk oleh Ketua untuk menjadi anggota dalam Majelis'        
        ]);
        Kamus::create([
            'istilah'=>'Hakim Karier',
            'arti_istilah'=>
            'hakim pada pengadilan negeri, pengadilan tinggi, dan Mahkamah Agung yang ditetapkan sebagai hakim tindak pidana korupsi'        
        ]);
        Kamus::create([
            'istilah'=>'Hakim Ketua',
            'arti_istilah'=>
            'Hakim Anggota yang ditunjuk oleh Ketua untuk memimpin sidang'        
        ]);
        Kamus::create([
            'istilah'=>'Hakim Pengawas',
            'arti_istilah'=>
            'hakim yang ditunjuk oleh Pengadilan dalam putusan pailit atau putusan penundaan kewajiban pembayaran utang'        
        ]);
        Kamus::create([
            'istilah'=>'Hakim Tunggal',
            'arti_istilah'=>
            'Hakim yang ditunjuk oleh Ketua untuk memeriksa dan memutus Sengketa Pajak dengan acara cepat'        
        ]);
        Kamus::create([
            'istilah'=>'Halal',
            'arti_istilah'=>
            'suatu kondisi produk Hewan atau tindakan yang telah dinyatakan Halal sesuai dengan syariat Islam.'        
        ]);
        Kamus::create([
            'istilah'=>'HAM',
            'arti_istilah'=>
            'seperangkat hak yang melekat pada hakikat dan keberadaan manusia sebagai makhluk ciptaan Tuhan Yang Maha Esa dan merupakan anugerah-Nya yang wajib dihormati, drjunjung tinggi, dan dilindungi oleh negara, hukum, pemerintah, dan setiap orang demi kehormatan serta pelindungan harkat dan martabat manusia'        
        ]);
        Kamus::create([
            'istilah'=>'HGPA',
            'arti_istilah'=>
            'Hak untuk memperoleh dan memakai Air.'        
        ]);
        Kamus::create([
            'istilah'=>'HGUA',
            'arti_istilah'=>
            'hak untuk memperoleh dan mengusahakan Air.'        
        ]);
        Kamus::create([
            'istilah'=>'Hibah',
            'arti_istilah'=>
            'Pemberian cuma-cuma yang berlaku saat pemberi hidup'        
        ]);
        Kamus::create([
            'istilah'=>'Harta Bersama',
            'arti_istilah'=>
            'Harta benda yang diperoleh selama perkawinan'        
        ]);
        Kamus::create([
            'istilah'=>'Harta gono-gini',
            'arti_istilah'=>
            'Harta Bersama'        
        ]);
        Kamus::create([
            'istilah'=>'Hukum Acara',
            'arti_istilah'=>
            'Aturan proses di pengadilan'        
        ]);
        Kamus::create([
            'istilah'=>'Hukum Administrasi',
            'arti_istilah'=>
            'Hukum yang mengatur penyelenggaraan negara'        
        ]);
        Kamus::create([
            'istilah'=>'Hukum Tata Negara',
            'arti_istilah'=>
            'Mengatur pokok Negara dan organisasi'        
        ]);
        Kamus::create([
            'istilah'=>'Hukum Perburuhan/Ketenagakerjaan',
            'arti_istilah'=>
            'Hubungan antara pekerja dan pemberi kerja'        
        ]);
        Kamus::create([
            'istilah'=>'Hukum Waris',
            'arti_istilah'=>
            'Mengatur perpindahan harta peninggalan'        
        ]);
        Kamus::create([
            'istilah'=>'Ideologi',
            'arti_istilah'=>
            'Cara memandang segala sesuatu'        
        ]);
        Kamus::create([
            'istilah'=>'Imparsial',
            'arti_istilah'=>
            'Tidak memihak, netral'        
        ]);
        Kamus::create([
            'istilah'=>'Inkracht van gewijsde',
            'arti_istilah'=>
            'Suatu perkara telah diputus oleh hakim, tidak ada upaya hukum lain yang lebih tinggi'        
        ]);
        Kamus::create([
            'istilah'=>'Jaminan Sosial Tenaga Kerja (Jamsostek)',
            'arti_istilah'=>
            'Perlindungan bagi pekerja atas risiko kerja, sakit, hamil, bersalin, tua, dan meninggal'        
        ]);
         Kamus::create([
            'istilah'=>'Jaminan Fidusia',
            'arti_istilah'=>
            'Jaminan benda bergerak baik berwujud maupun tidak berwujud'        
        ]);
        Kamus::create([
            'istilah'=>'Jaminan Kecelakaan Kerja',
            'arti_istilah'=>
            'Santunan bagi pekerja yang mengalami kecelakaan kerja'        
        ]);
        Kamus::create([
            'istilah'=>'Jaminan Kredit',
            'arti_istilah'=>
            'Penyerahan kekayaan seseorang untuk menjamin utang'        
        ]);
        Kamus::create([
            'istilah'=>'Jawaban',
            'arti_istilah'=>
            'Tanggapan tergugat terhadap gugatan'        
        ]);
        Kamus::create([
            'istilah'=>'Judicial Review',
            'arti_istilah'=>
            'Upaya pengujian undang-undang terhadap konstitusi'        
        ]);
        Kamus::create([
            'istilah'=>'Kasasi',
            'arti_istilah'=>
            'Upaya hukum ke Mahkamah Agung untuk memeriksa kembali putusan pengadilan sebelumnya'        
        ]);
        Kamus::create([
            'istilah'=>'Keimigrasian',
            'arti_istilah'=>
            'Hal lalu lintas orang masuk/keluar wilayah RI'        
        ]);
        Kamus::create([
            'istilah'=>'Kekerasan Dalam Rumah Tangga',
            'arti_istilah'=>
            'Perbuatan terhadap anggota keluarga yang menyebabkan penderitaan fisik, seksual, psikologis, ekonomi'        
        ]);
        Kamus::create([
            'istilah'=>'Kekuatan Eksekutorial',
            'arti_istilah'=>
            'Kekuatan melaksanakan isi putusan seperti grosse akta'        
        ]);
        Kamus::create([
            'istilah'=>'Keterangan Ahli',
            'arti_istilah'=>
            'Pendapat dari ahli di persidangan'        
        ]);
        Kamus::create([
            'istilah'=>'Keterangan Saksi',
            'arti_istilah'=>
            'Pernyataan tentang peristiwa yang dilihat, didengar, dialami'        
        ]);
        Kamus::create([
            'istilah'=>'Keterangan Terdakwa',
            'arti_istilah'=>
            'Pernyataan terdakwa mengenai perbuatannya'        
        ]);
        Kamus::create([
            'istilah'=>'Keputusan Tata Usaha Negara',
            'arti_istilah'=>
            'Penetapan tertulis oleh pejabat TUN'        
        ]);
        Kamus::create([
            'istilah'=>'Klausul Eksem',
            'arti_istilah'=>
            'Klausul yang mengecualikan pihak dari perjanjian'        
        ]);
        Kamus::create([
            'istilah'=>'Komparisi',
            'arti_istilah'=>
            'Sidang untuk mendengar keterangan para pihak'        
        ]);
        Kamus::create([
            'istilah'=>'Kompensasi',
            'arti_istilah'=>
            'Ganti kerugian dari Negara kepada korban pelanggaran HAM'        
        ]);
        Kamus::create([
            'istilah'=>'Kompetensi',
            'arti_istilah'=>
            'Kewenangan pengadilan memutus perkara'        
        ]);
        Kamus::create([
            'istilah'=>'Kompetensi Absolut',
            'arti_istilah'=>
            'Wewenang peradilan berdasarkan jenis perkara'        
        ]);
        Kamus::create([
            'istilah'=>'Kompetensi Relatif',
            'arti_istilah'=>
            'Berdasarkan wilayah hukum'        
        ]);
        Kamus::create([
            'istilah'=>'Konsiliasi',
            'arti_istilah'=>
            'Penyelesaian sengketa dengan bantuan pihak ketiga'        
        ]);
        Kamus::create([
            'istilah'=>'Konstitusi',
            'arti_istilah'=>
            'Undang-Undang Dasar'        
        ]);
        Kamus::create([
            'istilah'=>'Konstitusional',
            'arti_istilah'=>
            'Sesuai dengan konstitusi'        
        ]);
        Kamus::create([
            'istilah'=>'Korupsi',
            'arti_istilah'=>
            'Penyalahgunaan jabatan untuk keuntungan sendiri'        
        ]);
        Kamus::create([
            'istilah'=>'Kredit',
            'arti_istilah'=>
            'Penyediaan uang oleh bank untuk nasabah'        
        ]);
        Kamus::create([
            'istilah'=>'Kreditur',
            'arti_istilah'=>
            'Pihak yang memberikan pinjaman'        
        ]);
        Kamus::create([
            'istilah'=>'Kuasa',
            'arti_istilah'=>
            'Kemampuan seseorang untuk melakukan sesuatu'        
        ]);
        Kamus::create([
            'istilah'=>'Kuasa Hukum',
            'arti_istilah'=>
            'Pengacara yang diberi kuasa'        
        ]);
        Kamus::create([
            'istilah'=>'Laporan',
            'arti_istilah'=>
            'Pemberitahuan adanya perbuatan pidana kepada pejabat berwenang'        
        ]);
        Kamus::create([
            'istilah'=>'Leasing',
            'arti_istilah'=>
            'Pembiayaan barang modal dengan hak opsi'        
        ]);
        Kamus::create([
            'istilah'=>'Legalisasi',
            'arti_istilah'=>
            'Pengesahan'        
        ]);
        Kamus::create([
            'istilah'=>'Legal Standing',
            'arti_istilah'=>
            'Hak gugat organisasi'        
        ]);
        Kamus::create([
            'istilah'=>'Legislasi',
            'arti_istilah'=>
            'Proses pembuatan UU'        
        ]);
        Kamus::create([
            'istilah'=>'Legislatif',
            'arti_istilah'=>
            'Kekuasaan membuat UU'        
        ]);
        Kamus::create([
            'istilah'=>'Lembaga Arbitrase',
            'arti_istilah'=>
            'Badan untuk menyelesaikan sengketa di luar pengadilan'        
        ]);
        Kamus::create([
            'istilah'=>'Lessee',
            'arti_istilah'=>
            'Pihak yang menyewa barang modal'        
        ]);
        Kamus::create([
            'istilah'=>'Lessor',
            'arti_istilah'=>
            'Pihak yang menyewakan barang modal'        
        ]);
        Kamus::create([
            'istilah'=>'Limitatif',
            'arti_istilah'=>
            'Terbatas'        
        ]);
        Kamus::create([
            'istilah'=>'Locus delicti',
            'arti_istilah'=>
            'Tempat terjadinya kejahatan'        
        ]);
        Kamus::create([
            'istilah'=>'Mediasi',
            'arti_istilah'=>
            'Kesepakatan tertulis para pihak yang dibantu mediator'        
        ]);
        Kamus::create([
            'istilah'=>'Mogok Kerja',
            'arti_istilah'=>
            'Kesepakatan tertulis para pihak yang dibantu mediator'        
        ]);
        Kamus::create([
            'istilah'=>'Monopoli',
            'arti_istilah'=>
            'Keadaan pasar dikuasai satu pelaku'        
        ]);
        Kamus::create([
            'istilah'=>'Mazhab',
            'arti_istilah'=>
            'Aliran pemikiran'        
        ]);
        Kamus::create([
            'istilah'=>'Ombudsman',
            'arti_istilah'=>
            'Lembaga independen untuk mengawasi pelayanan publik'        
        ]);
        Kamus::create([
            'istilah'=>'Operating Leasing',
            'arti_istilah'=>
            'Leasing tanpa hak opsi di akhir masa sewa'        
        ]);
        Kamus::create([
            'istilah'=>'PHK',
            'arti_istilah'=>
            'Pemutusan hubungan kerja'        
        ]);
        Kamus::create([
            'istilah'=>'Pelanggaran Berat HAM',
            'arti_istilah'=>
            'Pembunuhan massal, penghilangan orang, penyiksaan sistematis'        
        ]);
        Kamus::create([
            'istilah'=>'Pemberian Fidusia',
            'arti_istilah'=>
            'Memberikan objek jaminan fidusia'        
        ]);
        Kamus::create([
            'istilah'=>'Pemberian Kuasa',
            'arti_istilah'=>
            'Persetujuan seseorang memberi kekuasaan pada orang lain'        
        ]);
        Kamus::create([
            'istilah'=>'Penahanan',
            'arti_istilah'=>
            'Penempatan tersangka/terdakwa di tempat tertentu'        
        ]);
        Kamus::create([
            'istilah'=>'Penangkapan',
            'arti_istilah'=>
            'Penahanan sementara oleh penyidik'        
        ]);
        Kamus::create([
            'istilah'=>'Penanggungan (Borgtocht)',
            'arti_istilah'=>
            'Perjanjian penjaminan utang'        
        ]);
        Kamus::create([
            'istilah'=>'Penataan Ruang',
            'arti_istilah'=>
            'Proses perencanaan penggunaan ruang'        
        ]);
        Kamus::create([
            'istilah'=>'Pengadilan Agama',
            'arti_istilah'=>
            'Mengadili perkara Islam'        
        ]);
        Kamus::create([
            'istilah'=>'Pengadilan HAM',
            'arti_istilah'=>
            'Mengadili pelanggaran HAM berat'        
        ]);
        Kamus::create([
            'istilah'=>'Pengadilan Hubungan Industrial',
            'arti_istilah'=>
            'Mengadili sengketa ketenagakerjaan'        
        ]);
        Kamus::create([
            'istilah'=>'Pengadilan Tipikor',
            'arti_istilah'=>
            'Mengadili korupsi'        
        ]);
        Kamus::create([
            'istilah'=>'Pengadilan Militer',
            'arti_istilah'=>
            'Mengadili tindak pidana militer'        
        ]);
        Kamus::create([
            'istilah'=>'Pengadilan Pajak',
            'arti_istilah'=>
            'Sengketa pajak'        
        ]);
        Kamus::create([
            'istilah'=>'Pengadilan Niaga',
            'arti_istilah'=>
            'Sengketa kepailitan'        
        ]);
        Kamus::create([
            'istilah'=>'Pengadilan PTUN',
            'arti_istilah'=>
            'Sengketa keputusan TUN'        
        ]);
        Kamus::create([
            'istilah'=>'Pengaduan',
            'arti_istilah'=>
            'Permintaan kepada pejabat berwenang untuk bertindak'        
        ]);
        Kamus::create([
            'istilah'=>'Pengampunan',
            'arti_istilah'=>
            'Keadaan hilangnya sifat pidana'        
        ]);
        Kamus::create([
            'istilah'=>'Penyelidik',
            'arti_istilah'=>
            'Orang yang berwenang melakukan penyelidikan'        
        ]);
         Kamus::create([
            'istilah'=>'Penyelidikan',
            'arti_istilah'=>
            'Serangkaian tindakan untuk mencari bukti permulaan'        
        ]);
        Kamus::create([
            'istilah'=>'Perdagangan Perempuan',
            'arti_istilah'=>
            'Eksploitasi perempuan untuk keuntungan'        
        ]);
        Kamus::create([
            'istilah'=>'Perikatan',
            'arti_istilah'=>
            'Hubungan hukum menimbulkan hak dan kewajiban'        
        ]);
        Kamus::create([
            'istilah'=>'Perjanjian',
            'arti_istilah'=>
            'Kesepakatan yang mengikat'        
        ]);
        Kamus::create([
            'istilah'=>'Perjanjian Kerja',
            'arti_istilah'=>
            'Hubungan kerja antara buruh dan pengusaha'        
        ]);
        Kamus::create([
            'istilah'=>'Perjanjian Kerja Bersama',
            'arti_istilah'=>
            'Kesepakatan antara serikat buruh dan pengusaha'        
        ]);
        Kamus::create([
            'istilah'=>'Perjanjian Kerja Waktu Tidak Tentu',
            'arti_istilah'=>
            'Perjanjian tanpa batas waktu'        
        ]);
        Kamus::create([
            'istilah'=>'Perjanjian Penempatan',
            'arti_istilah'=>
            'Penempatan TKI'        
        ]);
        Kamus::create([
            'istilah'=>'Perkawinan Campur',
            'arti_istilah'=>
            'Perkawinan antara warga negara berbeda'        
        ]);
        Kamus::create([
            'istilah'=>'Perusahaan Usaha Tidak Sehat',
            'arti_istilah'=>
            'Perusahaan yang merugikan persaingan'        
        ]);
        Kamus::create([
            'istilah'=>'Perselisihan Hubungan Industrial',
            'arti_istilah'=>
            'Perselisihan pengusaha dan buruh'        
        ]);
        Kamus::create([
            'istilah'=>'Perselisihan Hak',
            'arti_istilah'=>
            'Perselisihan tentang pemenuhan hak'        
        ]);
        Kamus::create([
            'istilah'=>'Perselisihan Kepentingan',
            'arti_istilah'=>
            'Perselisihan syarat kerja baru'        
        ]);
        Kamus::create([
            'istilah'=>'Perselisihan PHK',
            'arti_istilah'=>
            'Perselisihan akibat PHK'        
        ]);
        Kamus::create([
            'istilah'=>'Perselisihan antar Serikat Pekerja',
            'arti_istilah'=>
            'Perselisihan antar serikat buruh'        
        ]);
        Kamus::create([
            'istilah'=>'Perundingan Bipartit',
            'arti_istilah'=>
            'Negosiasi antara pengusaha dan serikat buruh'        
        ]);
        Kamus::create([
            'istilah'=>'Petitum',
            'arti_istilah'=>
            'Tuntutan dalam gugatan'        
        ]);
        Kamus::create([
            'istilah'=>'Piutang',
            'arti_istilah'=>
            'Hak untuk menerima pembayaran'        
        ]);
        Kamus::create([
            'istilah'=>'Posita',
            'arti_istilah'=>
            'Uraian alasan gugatan'        
        ]);
        Kamus::create([
            'istilah'=>'Praduga Tidak Bersalah',
            'arti_istilah'=>
            'Asas bahwa terdakwa dianggap tidak bersalah sebelum diputus'        
        ]);
        Kamus::create([
            'istilah'=>'Pra peradilan',
            'arti_istilah'=>
            'Pemeriksaan atas sah tidaknya penangkapan/penahanan'        
        ]);
        Kamus::create([
            'istilah'=>'Putusan pengadilan',
            'arti_istilah'=>
            'Keputusan hakim'        
        ]);
        Kamus::create([
            'istilah'=>'Putusan Provisi',
            'arti_istilah'=>
            'Putusan sementara untuk mencegah kerugian'        
        ]);
        Kamus::create([
            'istilah'=>'Putusan Sela',
            'arti_istilah'=>
            'Putusan di sela sidang'        
        ]);
        Kamus::create([
            'istilah'=>'Putusan Verstek',
            'arti_istilah'=>
            'Putusan tanpa hadirnya tergugat'        
        ]);
        Kamus::create([
            'istilah'=>'Rehabilitasi',
            'arti_istilah'=>
            'Pemulihan hak seseorang'        
        ]);
        Kamus::create([
            'istilah'=>'Reparasi',
            'arti_istilah'=>
            'Pemulihan kondisi korban HAM'        
        ]);
        Kamus::create([
            'istilah'=>'Replik',
            'arti_istilah'=>
            'Tanggapan penggugat atas jawaban tergugat'        
        ]);
        Kamus::create([
            'istilah'=>'Restitusi',
            'arti_istilah'=>
            'Ganti kerugian dari pelaku ke korban'        
        ]);
        Kamus::create([
            'istilah'=>'Sale and Lease Back',
            'arti_istilah'=>
            'Menjual barang kemudian menyewanya kembali'        
        ]);
        Kamus::create([
            'istilah'=>'Sertifikat',
            'arti_istilah'=>
            'Tanda bukti hak atas tanah'        
        ]);
        Kamus::create([
            'istilah'=>'Serikat Buruh',
            'arti_istilah'=>
            'Organisasi buruh'        
        ]);
        Kamus::create([
            'istilah'=>'Staatsblad',
            'arti_istilah'=>
            'Lembaran Negara'        
        ]);
        Kamus::create([
            'istilah'=>'Standing',
            'arti_istilah'=>
            'Hak untuk menggugat'        
        ]);
        Kamus::create([
            'istilah'=>'Terdakwa',
            'arti_istilah'=>
            'Seseorang yang diadili'        
        ]);
        Kamus::create([
            'istilah'=>'Tersangka',
            'arti_istilah'=>
            'Seseorang yang diduga melakukan tindak pidana'        
        ]);
        Kamus::create([
            'istilah'=>'Tertangkap Tangan',
            'arti_istilah'=>
            'Tertangkap saat melakukan kejahatan'        
        ]);
        Kamus::create([
            'istilah'=>'Tunjangan Tetap',
            'arti_istilah'=>
            'Diberikan tetap tiap bulan'        
        ]);
        Kamus::create([
            'istilah'=>'Tunjangan Tidak Tetap',
            'arti_istilah'=>
            'Diberikan tidak rutin'        
        ]);
        Kamus::create([
            'istilah'=>'Upah',
            'arti_istilah'=>
            'Imbalan dari pengusaha ke pekerja'        
        ]);
        Kamus::create([
            'istilah'=>'Upah Lembur',
            'arti_istilah'=>
            'Upah atas kerja melebihi jam kerja'        
        ]);
        Kamus::create([
            'istilah'=>'Upah Minimum',
            'arti_istilah'=>
            'Upah terendah yang ditetapkan pemerintah'        
        ]);
        Kamus::create([
            'istilah'=>'Upah Kota/Kabupaten (UMK)',
            'arti_istilah'=>
            'Upah minimum kabupaten/kota'        
        ]);
        Kamus::create([
            'istilah'=>'Upah Minimum Provinsi (UMP)',
            'arti_istilah'=>
            'Upah minimum provinsi'        
        ]);
        Kamus::create([
            'istilah'=>'Upah Pokok',
            'arti_istilah'=>
            'Upah dasar tanpa tunjangan'        
        ]);
        Kamus::create([
            'istilah'=>'Upah Hukum',
            'arti_istilah'=>
            'Upah yang wajib dibayar meski tidak bekerja'        
        ]);
        Kamus::create([
            'istilah'=>'Verifikasi',
            'arti_istilah'=>
            'kegiatan menghitung nilai TKDN Barang/Jasa dan nilai Bobot Manfaat Perusahaan berdasarkan data yang diambil atau dikumpulkan dari kegiatan usaha produsen Barang, perusahaan Jasa, atau penyedia gabungan Barang dan Jasa.'        
        ]);
        Kamus::create([
            'istilah'=>'Veteriner',
            'arti_istilah'=>
            'segala urusan yang berkaitan dengan Hewan dan penyakit Hewan.'        
        ]);
        Kamus::create([
            'istilah'=>'Visa',
            'arti_istilah'=>
            'keterangan tertulis yang diberikan oleh pejabat yang berwenang di Perwakilan Republik Indonesia atau di tempat lain yang ditetapkan oleh Pemerintah Republik Indonesia yang memuat persetujuan bagi Orang Asing untuk melakukan perjalanan ke Wilayah Indonesia dan menjadi dasar untuk pemberian Izin Tinggal.'        
        ]);
        Kamus::create([
            'istilah'=>'Wanprestasi',
            'arti_istilah'=>
            'Cidera janji'        
        ]);
        Kamus::create([
            'istilah'=>'Wasiat',
            'arti_istilah'=>
            'Kehendak pewaris membagikan harta'        
        ]);
        Kamus::create([
            'istilah'=>'Wakaf',
            'arti_istilah'=>
            'perbuatan hukum wakif untuk memisahkan dan/atau menyerahkan sebagian harta benda miliknya untuk dimanfaatkan selamanya atau untuk jangka waktu tertentu sesuai dengan kepentingannya guna keperluan ibadah dan/atau kesejahteraan umum menurut syariah'        
        ]);
        Kamus::create([
            'istilah'=>'Wakif',
            'arti_istilah'=>
            'pihak yang mewakafkan harta benda miliknya'        
        ]);
        Kamus::create([
            'istilah'=>'Wali',
            'arti_istilah'=>
            'orang atau badan yang dalam kenyataannya menjalankan kekuasaan asuh sebagai orang tua terhadap anak.'        
        ]);
        Kamus::create([
            'istilah'=>'Wali Amanat',
            'arti_istilah'=>
            'pihak yang mewakili kepentingan pemegang SBSN sesuai dengan yang diperjanjikan.'        
        ]);
        Kamus::create([
            'istilah'=>'Waralaba',
            'arti_istilah'=>
            'hak khusus yang dimiliki oleh orang perseorangan atau badan usaha terhadap sistem bisnis dengan ciri khas usaha dalam rangka memasarkan barang dan/atau jasa yang telah terbukti berhasil dan dapat dimanfaatkan dan/atau digunakan oleh pihak lain berdasarkan Perjanjian Waralaba.'        
        ]);
        Kamus::create([
            'istilah'=>'Wewenang',
            'arti_istilah'=>
            'hak yang dimiliki oleh Badan dan/atau Pejabat Pemerintahan atau penyelenggara negara lainnya untuk mengambil keputusan dan/atau tindakan dalam penyelenggaraan pemerintahan'        
        ]);

        Kamus::create([
            'istilah'=>'Yayasan',
            'arti_istilah'=>
            'badan hukum yang terdiri atas kekayaan yang dipisahkan dan diperuntukkan untuk mencapai tujuan tertentu di bidang sosial, keagamaan, dan kemanusiaan, yang tidak mempunyai anggota.'        
        ]);
        Kamus::create([
            'istilah'=>'Yuridiksi',
            'arti_istilah'=>
            'Kekuasaan mengadili'        
        ]);
        Kamus::create([
            'istilah'=>'Yudikatif',
            'arti_istilah'=>
            'Kekuasaan kehakiman'        
        ]);
        Kamus::create([
            'istilah'=>'Yurisprudensi',
            'arti_istilah'=>
            'Putusan hakim sebelumnya yang diikuti'        
        ]);
        Kamus::create([
            'istilah'=>'Zakat',
            'arti_istilah'=>
            'harta yang wajib dikeluarkan oleh seorang muslim atau badan usaha untuk diberikan kepada yang berhak menerimanya sesuai dengan syariat Islam.'        
        ]);
        Kamus::create([
            'istilah'=>'Zona',
            'arti_istilah'=>
            'ruang yang penggunaannya disepakati bersama antara berbagai pemangku kepentingan dan telah ditetapkan status hukumnya '        
        ]);
        Kamus::create([
            'istilah'=>'Zona Ekonomi Ekslusif (ZEE) Indonesia',
            'arti_istilah'=>
            'suatu area di luar dan berdampingan dengan laut teritorial Indonesia sebagaimana dimaksud dalam Undang-Undang yang mengatur mengenai perairan Indonesia dengan batas terluar 200 (dua ratus) mil laut dari garis pangkal dari mana lebar laut teritorial diukur. '        
        ]);
        Kamus::create([
            'istilah'=>'Zonasi',
            'arti_istilah'=>
            'penentuan batas-batas keruangan Situs Cagar Budaya dan Kawasan Cagar Budaya sesuai dengan kebutuhan. - Selengkapnya https://www.hukumonline.com/kamus/z/zonasi'        
        ]);





    }
}
