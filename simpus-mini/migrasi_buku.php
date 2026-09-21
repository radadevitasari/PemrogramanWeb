<?php
require __DIR__ . '/includes/koneksi.php';

// Data JSON dummy/legacy dari Jobsheet 6
$jsonString = '[
    {"judul": "Pemrograman Web dengan PHP", "pengarang": "Budi Raharjo", "tahun": 2022, "isbn": "978-602-1234-01-1", "stok": 5, "kategori": "Pemrograman"},
    {"judul": "Mastering PostgreSQL", "pengarang": "Ahmad Hanafi", "tahun": 2023, "isbn": "978-602-1234-02-8", "stok": 3, "kategori": "Database"},
    {"judul": "Struktur Data & Algoritma", "pengarang": "Rina Pratama", "tahun": 2021, "isbn": "978-602-1234-03-5", "stok": 8, "kategori": "Informatika"}
]';

$daftarBuku = json_decode($jsonString, true);

if (empty($daftarBuku)) {
    die("Data JSON tidak valid.");
}

// Prepare statement untuk insert data ke PostgreSQL
$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)"
);

$jumlahBerhasil = 0;

foreach ($daftarBuku as $buku) {
    try {
        $stmt->execute([
            'judul'     => $buku['judul'],
            'pengarang' => $buku['pengarang'],
            'tahun'     => $buku['tahun'],
            'isbn'      => $buku['isbn'],
            'stok'      => $buku['stok'],
            'kategori'  => $buku['kategori']
        ]);
        $jumlahBerhasil++;
    } catch (PDOException $e) {
        echo "Gagal migrasi buku '{$buku['judul']}': " . $e->getMessage() . "<br>";
    }
}

echo "<h3>Migrasi Selesai! Berhasil memasukkan $jumlahBerhasil data buku dari JSON ke PostgreSQL.</h3>";
echo '<a href="buku/list.php">Lihat Daftar Buku</a>';