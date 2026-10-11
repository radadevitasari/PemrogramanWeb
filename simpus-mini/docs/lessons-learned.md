# Lessons Learned: SIMPUS-Mini

## Konsep yang paling menantang
Menurut saya yang paling sulit adalah transaction dan SELECT ... FOR UPDATE di modul peminjaman. Awalnya saya pikir cukup mencatat peminjaman lalu mengurangi stok buku saja. Ternyata kalau salah satu langkah gagal di tengah jalan, datanya jadi tidak cocok: peminjaman tercatat tapi stok tidak berkurang. Saya juga sulit membayangkan bagaimana dua orang bisa meminjam buku yang sama di waktu hampir bersamaan.

## Bagaimana saya memahaminya
Saya baru benar-benar paham setelah mencobanya sendiri. Saya membuka dua tab, lalu meminjam buku yang stoknya tinggal 1. Di tab pertama berhasil, di tab kedua muncul pesan "Stok buku tidak tersedia". Dari situ saya mengerti bahwa FOR UPDATE membuat proses kedua membaca stok yang sudah terbaru, sehingga stok tidak menjadi negatif. Transaction juga membuat kedua langkah berhasil bersama atau dibatalkan bersama.

## Hambatan yang saya temui
Saat menambah kolom tanggal_jatuh_tempo, saya sempat mendapat error "column does not exist" karena saya mengubah kode PHP tapi belum menjalankan perintah ALTER TABLE di database. Dari situ saya sadar bahwa perubahan kode dan perubahan database harus dikerjakan bersamaan. Saya juga sempat bingung saat gambar di manual pengguna tidak tampil, ternyata file gambarnya tersimpan di folder yang salah dan namanya memakai huruf besar, padahal di manual ditulis huruf kecil.

## Konsep lain yang saya pelajari
Selain transaction, saya belajar tentang keamanan web di Jobsheet 11. Saya mencoba menyimpan judul buku berisi script, dan ternyata tampil sebagai teks biasa karena sudah dibungkus fungsi e(), jadi tidak dijalankan oleh browser. Dari situ saya paham kenapa semua data dari pengguna harus di-escape sebelum ditampilkan. Saya juga belajar tentang token CSRF yang mencegah form dikirim dari situs lain, dan JOIN yang menggabungkan data beberapa tabel supaya riwayat peminjaman bisa menampilkan judul buku dan nama anggota, bukan hanya angka ID.

## Perjalanan dari Jobsheet 1 sampai 13
Saya memulai dari halaman HTML statis, lalu menambah CSS, tampilan responsif, JavaScript, PHP, dan database PostgreSQL. Setelah itu saya menambah fitur CRUD, login petugas, keamanan, dan modul peminjaman. Di Jobsheet 13 saya memisahkan konfigurasi database ke config.php dan membuat dokumentasi: manual pengguna, .env.example, dan lessons learned ini. Setiap jobsheet membangun di atas yang sebelumnya, jadi kalau satu bagian dasar belum paham, bagian berikutnya ikut terasa sulit. Saya juga terbiasa melakukan commit per langkah, sehingga perkembangan proyek bisa dilihat dengan jelas.

## Yang akan saya lakukan di proyek berikutnya
Saya akan menyimpan perubahan database dalam file SQL yang berurutan supaya mudah dijalankan ulang, menguji fitur dengan skenario yang nyata seperti dua tab, dan memeriksa nama serta lokasi file sejak awal agar tidak ada gambar atau link yang rusak. Saya juga akan menulis dokumentasi sambil mengerjakan, bukan di akhir.