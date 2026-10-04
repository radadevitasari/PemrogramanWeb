<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// batasi percobaan login gagal per username
$maxGagal = 3;
$waktuKunci = 60; // detik
$key = strtolower($username);
$data = $_SESSION['login_gagal'][$key] ?? ['jumlah' => 0, 'terakhir' => 0];

if ($data['jumlah'] >= $maxGagal) {
    $sisa = $waktuKunci - (time() - $data['terakhir']);
    if ($sisa > 0) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => "Terlalu banyak percobaan gagal. Coba lagi dalam $sisa detik."];
        header('Location: login.php');
        exit;
    }
    $data = ['jumlah' => 0, 'terakhir' => 0];
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    unset($_SESSION['login_gagal'][$key]);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    
    if (!empty($_POST['ingat'])) {
        $token = bin2hex(random_bytes(32));
        $upd = $pdo->prepare("UPDATE users SET remember_token = :t WHERE id = :id");
        $upd->execute(['t' => hash('sha256', $token), 'id' => $user['id']]);
        setcookie('remember', $user['id'] . ':' . $token, [
            'expires' => time() + 60 * 60 * 24 * 30,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
     header('Location: ../index.php');
    exit;
}

// catat percobaan gagal
$data['jumlah']++;
$data['terakhir'] = time();
$_SESSION['login_gagal'][$key] = $data;

if ($data['jumlah'] >= $maxGagal) {
    $pesan = "Terlalu banyak percobaan gagal. Coba lagi dalam $waktuKunci detik.";
} else {
    $pesan = 'Username atau password salah. Sisa percobaan: ' . ($maxGagal - $data['jumlah']) . '.';
}

$_SESSION['flash'] = ['type' => 'error', 'pesan' => $pesan];
header('Location: login.php');
exit;
