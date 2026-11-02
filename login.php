<?php
require_once __DIR__ . '/auth.php';
if (!empty($_SESSION['id_user'])) {
    header('Location: admin.php');
    exit;
}
$error = '';
$countResult = mysqli_query($koneksi, 'SELECT COUNT(*) AS total FROM users');
$needsSetup = $countResult && (int) mysqli_fetch_assoc($countResult)['total'] === 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = mysqli_prepare($koneksi, 'SELECT id_user, username, password, nama_lengkap FROM users WHERE username = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    if ($userData && password_verify($password, $userData['password'])) {
        session_regenerate_id(true);
        $_SESSION['id_user'] = (int) $userData['id_user'];
        $_SESSION['username'] = $userData['username'];
        $_SESSION['nama_lengkap'] = $userData['nama_lengkap'];
        header('Location: admin.php');
        exit;
    }
    $error = 'Username atau password tidak sesuai.';
}
$token = csrf_token();
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="theme-color" content="#091b10"><title>Login Admin — AgriLokal Nusantara</title><link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet"><style>
:root{--forest:#091b10;--card:#122a1b;--lime:#c5f015;--mint:#40d9aa;--text:#f4f7f2;--muted:#a2b5a8}*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:24px;background:var(--forest);color:var(--text);font-family:'DM Sans',sans-serif}body:before{content:"";position:fixed;inset:0;pointer-events:none;opacity:.25;background-image:radial-gradient(#93d37030 .8px,transparent .8px);background-size:27px 27px}.login-card{position:relative;width:min(100%,440px);padding:38px;border:1px solid #ffffff16;border-radius:26px;background:linear-gradient(145deg,#142d1d,#0e2115);box-shadow:0 30px 80px #0006}.brand{display:flex;align-items:center;gap:11px;text-decoration:none;color:var(--text);font:800 20px Manrope,sans-serif}.mark{width:42px;height:42px;display:grid;place-items:center;border-radius:14px;background:var(--lime);color:#12210d;font-size:22px}.brand small{display:block;margin-top:2px;color:#91b633;font:700 9px 'DM Sans',sans-serif;letter-spacing:1px}.eyebrow{margin:30px 0 8px;color:var(--mint);font-size:12px;font-weight:800;letter-spacing:1px}h1{margin:0;font:800 30px Manrope,sans-serif;letter-spacing:-1px}.intro{margin:10px 0 26px;color:var(--muted);font-size:14px;line-height:1.7}.field{margin:16px 0}.field label{display:block;margin-bottom:8px;font-weight:700;font-size:13px}.field input{width:100%;height:49px;padding:0 14px;border:1px solid #ffffff20;border-radius:12px;outline:none;background:#091b10;color:white;font:500 14px 'DM Sans',sans-serif}.field input:focus{border-color:var(--mint);box-shadow:0 0 0 3px #40d9aa20}.submit{width:100%;height:49px;margin-top:8px;border:0;border-radius:12px;background:var(--lime);color:#111a0c;font-weight:800;font-size:14px;cursor:pointer}.error{padding:12px 14px;border:1px solid #ff716055;border-radius:11px;background:#ff716015;color:#ffb1aa;font-size:13px}.back{display:block;margin-top:20px;text-align:center;color:#a8b9ad;text-decoration:none;font-size:13px}.back:hover{color:var(--lime)}@media(max-width:480px){.login-card{padding:28px 22px}}
</style></head><body><main class="login-card"><a class="brand" href="index.php"><span class="mark">✳</span><span>AgriLokal<small>PANEL MANAJEMEN</small></span></a><div class="eyebrow">AREA PENGELOLA</div><h1>Selamat datang.</h1><p class="intro">Masuk untuk mengelola katalog dan ketersediaan produk AgriLokal.</p><?php if ($error !== ''): ?><div class="error" role="alert"><?= h($error) ?></div><?php endif; ?><form method="post" action="login.php"><input type="hidden" name="csrf_token" value="<?= h($token) ?>"><div class="field"><label for="username">Username</label><input id="username" name="username" type="text" autocomplete="username" required maxlength="100"></div><div class="field"><label for="password">Password</label><input id="password" name="password" type="password" autocomplete="current-password" required></div><button class="submit" type="submit">Login ke Dashboard <span aria-hidden="true">↗</span></button></form><?php if ($needsSetup): ?><a class="back" href="register.php">Belum ada akun? Buat admin pertama</a><?php endif; ?><a class="back" href="index.php">← Kembali ke katalog</a></main></body></html>