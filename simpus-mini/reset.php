<?php
session_start();
require __DIR__ . '/includes/koneksi.php';

$pdo->exec("DELETE FROM buku");
$pdo->exec("DELETE FROM anggota");

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Semua data berhasil direset.'];
header('Location: index.php');
exit;