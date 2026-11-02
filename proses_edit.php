<?php
require_once __DIR__ . '/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: admin.php'); exit; }
verify_csrf();
$id = filter_var($_POST['id_produk'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$nama = trim($_POST['nama_produk'] ?? '');
$harga = filter_var($_POST['harga'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
$stok = filter_var($_POST['stok'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
$deskripsi = trim($_POST['deskripsi'] ?? '');
if (!$id || $nama === '' || strlen($nama) > 150 || $harga === false || $stok === false || $deskripsi === '') redirect_with_message('admin.php', 'Data produk tidak valid.');
$find = mysqli_prepare($koneksi, 'SELECT foto FROM produk WHERE id_produk = ?');
mysqli_stmt_bind_param($find, 'i', $id);
mysqli_stmt_execute($find);
$current = mysqli_fetch_assoc(mysqli_stmt_get_result($find));
mysqli_stmt_close($find);
if (!$current) redirect_with_message('admin.php', 'Produk tidak ditemukan.');
$newFilename = null;
$file = $_FILES['foto'] ?? null;
if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 3 * 1024 * 1024) redirect_with_message('edit.php?id=' . $id, 'Foto gagal diunggah atau melebihi 3 MB.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($extensions[$mime])) redirect_with_message('edit.php?id=' . $id, 'Format foto harus JPG, PNG, atau WEBP.');
    $directory = __DIR__ . '/assets/images';
    if (!is_dir($directory) && !mkdir($directory, 0755, true)) redirect_with_message('edit.php?id=' . $id, 'Folder penyimpanan foto tidak dapat dibuat.');
    $newFilename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
    if (!move_uploaded_file($file['tmp_name'], $directory . '/' . $newFilename)) redirect_with_message('edit.php?id=' . $id, 'Foto gagal disimpan.');
}
if ($newFilename !== null) {
    $stmt = mysqli_prepare($koneksi, 'UPDATE produk SET nama_produk = ?, harga = ?, stok = ?, deskripsi = ?, foto = ? WHERE id_produk = ?');
    mysqli_stmt_bind_param($stmt, 'siissi', $nama, $harga, $stok, $deskripsi, $newFilename, $id);
} else {
    $stmt = mysqli_prepare($koneksi, 'UPDATE produk SET nama_produk = ?, harga = ?, stok = ?, deskripsi = ? WHERE id_produk = ?');
    mysqli_stmt_bind_param($stmt, 'siisi', $nama, $harga, $stok, $deskripsi, $id);
}
if (!mysqli_stmt_execute($stmt)) { if ($newFilename !== null) @unlink(__DIR__ . '/assets/images/' . $newFilename); redirect_with_message('edit.php?id=' . $id, 'Perubahan produk gagal disimpan.'); }
mysqli_stmt_close($stmt);
if ($newFilename !== null && !empty($current['foto'])) { $old = basename($current['foto']); if ($old !== $newFilename) @unlink(__DIR__ . '/assets/images/' . $old); }
redirect_with_message('admin.php', 'Produk berhasil diperbarui.');
?>