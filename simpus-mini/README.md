# SIMPUS-Mini — Sistem Perpustakaan Mini

Aplikasi web sederhana untuk mengelola data buku, anggota, serta transaksi
peminjaman/pengembalian, dengan autentikasi petugas.

**Stack:** HTML5, CSS3, JavaScript, PHP native, PostgreSQL (PDO_PGSQL).

## ERD Final

```
buku            anggota           users                  peminjaman
------          --------          ------                 -----------
id (PK)         id (PK)           id (PK)                id (PK)
judul           nama              nama                   buku_id (FK -> buku.id)
pengarang       no_anggota (UQ)   username (UQ)          anggota_id (FK -> anggota.id)
tahun           alamat            password (hash)        tanggal_pinjam
isbn            no_hp             role                   tanggal_jatuh_tempo
stok                              remember_token         tanggal_kembali
kategori                                                 status
```

## Fitur per Role

| Fitur | Tamu (tanpa login) | Petugas (login) |
|---|---|---|
| Lihat Beranda & statistik | Ya | Ya |
| Lihat Daftar Buku | Ya | Ya |
| Tambah/Edit/Hapus Buku | Tidak | Ya |
| Kelola Anggota (CRUD) | Tidak | Ya |
| Peminjaman Baru | Tidak | Ya |
| Pengembalian | Tidak | Ya |
| Riwayat Peminjaman | Tidak | Ya |

## Instalasi & Menjalankan

1. Salin folder proyek ke server (lokal atau hosting PHP + PostgreSQL).
2. Buat database dan impor skema **berurutan** (tabel `peminjaman`
   mereferensikan `buku` dan `anggota`):

```
createdb simpus_mini
psql -d simpus_mini -f sql/01_buku_anggota.sql
psql -d simpus_mini -f sql/02_users.sql
psql -d simpus_mini -f sql/03_peminjaman.sql
psql -d simpus_mini -f sql/04_jatuh_tempo.sql
```

3. Konfigurasi koneksi: kredensial dibaca dari `includes/config.php` lewat
   environment variable `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`
   (ada nilai cadangan untuk lokal). Contoh di PowerShell:

```
$env:DB_NAME="simpus_mini"; $env:DB_USER="produser"; $env:DB_PASS="rahasia"; php -S localhost:8000
```

   Jangan menaruh kredensial produksi asli di `config.php` lalu
   meng-commit-nya ke repository publik.

4. Jalankan `php -S localhost:8000`, buka `http://localhost:8000/index.php`,
   lalu daftar akun petugas lewat `auth/register.php`.

## Struktur Folder

```
simpus-mini/
├── index.php
├── includes/    koneksi, config, header, footer, auth, csrf, helpers, remember
├── assets/      css, js
├── buku/        CRUD Buku
├── anggota/     CRUD Anggota
├── auth/        Register, Login, Logout
├── peminjaman/  Peminjaman, Pengembalian, Riwayat
├── sql/         skema database (jalankan berurutan)
└── docs/        wireframe.md, security-checklist.md, manual-pengguna.md
```

## Dokumen Pendukung

- `docs/wireframe.md` — rancangan UX
- `docs/security-checklist.md` — audit keamanan
- `docs/manual-pengguna.md` — panduan penggunaan