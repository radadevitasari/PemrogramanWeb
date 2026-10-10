-- Jobsheet 12 (latihan): kolom jatuh tempo pada tabel peminjaman
ALTER TABLE peminjaman ADD COLUMN IF NOT EXISTS tanggal_jatuh_tempo DATE;

-- Isi data lama: jatuh tempo = 14 hari setelah tanggal pinjam
UPDATE peminjaman
SET tanggal_jatuh_tempo = tanggal_pinjam + INTERVAL '14 days'
WHERE tanggal_jatuh_tempo IS NULL;