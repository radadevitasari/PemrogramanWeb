<?php
// Login otomatis dari cookie "Ingat Saya". Dipanggil setelah session_start().
if (empty($_SESSION['user_id']) && !empty($_COOKIE['remember'])) {
    require_once __DIR__ . '/koneksi.php';

    [$uid, $token] = array_pad(explode(':', $_COOKIE['remember'], 2), 2, '');
    if (ctype_digit($uid) && $token !== '') {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $uid]);
        $u = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($u && !empty($u['remember_token']) && hash_equals($u['remember_token'], hash('sha256', $token))) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['nama'] = $u['nama'];
            $_SESSION['role'] = $u['role'];
        }
    }
}