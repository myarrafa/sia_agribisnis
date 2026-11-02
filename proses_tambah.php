<?php
require_once __DIR__ . '/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: tambah.php'); exit; }
verify_csrf();
$nama = trim($_POST['nama_produk'] ?? '');
$harga = filter_var($_POST['harga'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
$stok = filter_var($_POST['stok'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
$deskripsi = trim($_POST['deskripsi'] ?? '');
$file = $_FILES['foto'] ?? null;
if ($nama === '' || strlen($nama) > 150 || $harga === false || $stok === false || $deskripsi === '' || !$file || $file['error'] !== UPLOAD_ERR_OK) {
    redirect_with_message('tambah.php', 'Lengkapi semua data dan unggah foto yang valid.');
}
if ($file['size'] > 3 * 1024 * 1024) redirect_with_message('tambah.php', 'Ukuran foto maksimal 3 MB.');
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);
$extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
if (!isset($extensions[$mime])) redirect_with_message('tambah.php', 'Format foto harus JPG, PNG, atau WEBP.');
$directory = __DIR__ . '/assets/images';
if (!is_dir($directory) && !mkdir($directory, 0755, true)) redirect_with_message('tambah.php', 'Folder penyimpanan foto tidak dapat dibuat.');
$filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
if (!move_uploaded_file($file['tmp_name'], $directory . '/' . $filename)) redirect_with_message('tambah.php', 'Foto gagal disimpan. Periksa izin folder assets/images.');
$stmt = mysqli_prepare($koneksi, 'INSERT INTO produk (nama_produk, harga, stok, deskripsi, foto) VALUES (?, ?, ?, ?, ?)');
mysqli_stmt_bind_param($stmt, 'siiss', $nama, $harga, $stok, $deskripsi, $filename);
if (!mysqli_stmt_execute($stmt)) { @unlink($directory . '/' . $filename); redirect_with_message('tambah.php', 'Produk gagal disimpan ke database.'); }
mysqli_stmt_close($stmt);
redirect_with_message('admin.php', 'Produk berhasil ditambahkan.');
?>