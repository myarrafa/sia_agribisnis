<?php
require_once __DIR__ . '/auth.php';
$countResult = mysqli_query($koneksi, 'SELECT COUNT(*) AS total FROM users');
if (!$countResult) { http_response_code(500); exit('Tabel users belum tersedia. Impor database.sql terlebih dahulu.'); }
$userCount = (int) mysqli_fetch_assoc($countResult)['total'];
if ($userCount > 0) { http_response_code(403); exit('Akun admin pertama sudah dibuat. Pembuatan akun awal telah dinonaktifkan.'); }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $fullname = trim($_POST['nama_lengkap'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || strlen($username) > 100 || $fullname === '' || strlen($fullname) > 150 || strlen($password) < 10) {
        $error = 'Isi semua data. Password minimal 10 karakter.';
    } else {
        $check = mysqli_query($koneksi, 'SELECT COUNT(*) AS total FROM users');
        if ((int) mysqli_fetch_assoc($check)['total'] > 0) {
            http_response_code(403);
            exit('Akun admin pertama sudah dibuat.');
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($koneksi, 'INSERT INTO users (username, password, nama_lengkap) VALUES (?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'sss', $username, $hash, $fullname);
        if (mysqli_stmt_execute($stmt)) {
            session_regenerate_id(true);
            $_SESSION['id_user'] = mysqli_insert_id($koneksi);
            $_SESSION['username'] = $username;
            $_SESSION['nama_lengkap'] = $fullname;
            header('Location: admin.php');
            exit;
        }
        $error = 'Akun gagal dibuat. Username mungkin sudah digunakan.';
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="theme-color" content="#091b10"><title>Buat Admin Pertama — AgriLokal</title><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@700;800&display=swap" rel="stylesheet"><style>
:root{--bg:#091b10;--card:#122a1b;--lime:#c5f015;--mint:#40d9aa;--text:#f4f7f2;--muted:#a2b5a8}*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:24px;background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif}.card{width:min(100%,470px);padding:34px;border:1px solid #ffffff16;border-radius:24px;background:var(--card)}h1{margin:0;font:800 28px Manrope,sans-serif}.intro{color:var(--muted);line-height:1.65;font-size:14px}.field{margin:15px 0}.field label{display:block;margin-bottom:7px;font-size:13px;font-weight:700}.field input{width:100%;height:47px;padding:0 13px;border:1px solid #ffffff20;border-radius:10px;background:#091b10;color:white}.submit{width:100%;height:48px;margin-top:8px;border:0;border-radius:10px;background:var(--lime);color:#111a0c;font-weight:800;cursor:pointer}.error{margin:14px 0;padding:11px;border-radius:9px;background:#ff716018;color:#ffb1aa;font-size:13px}a{display:block;margin-top:18px;text-align:center;color:#b9c9bd;text-decoration:none;font-size:13px}.hint{color:var(--muted);font-size:11px}@media(max-width:480px){.card{padding:25px 20px}}
</style></head><body><main class="card"><div style="color:var(--mint);font-size:11px;font-weight:800;letter-spacing:1px;margin-bottom:8px">SETUP AWAL</div><h1>Buat akun admin pertama</h1><p class="intro">Form ini hanya tersedia sebelum akun admin pertama dibuat. Password disimpan menggunakan <code>password_hash()</code>.</p><?php if ($error !== ''): ?><div class="error" role="alert"><?= h($error) ?></div><?php endif; ?><form method="post" action="register.php"><input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>"><div class="field"><label for="nama_lengkap">Nama Lengkap</label><input id="nama_lengkap" name="nama_lengkap" maxlength="150" autocomplete="name" required></div><div class="field"><label for="username">Username</label><input id="username" name="username" maxlength="100" autocomplete="username" required></div><div class="field"><label for="password">Password</label><input id="password" name="password" type="password" minlength="10" autocomplete="new-password" required><span class="hint">Minimal 10 karakter.</span></div><button class="submit" type="submit">Buat Akun Admin</button></form><a href="login.php">Kembali ke halaman login</a></main></body></html>