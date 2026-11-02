<?php
require_once __DIR__ . '/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: admin.php'); exit; }
verify_csrf();
$id = filter_var($_POST['id_produk'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$id) redirect_with_message('admin.php', 'ID produk tidak valid.');
$find = mysqli_prepare($koneksi, 'SELECT foto FROM produk WHERE id_produk = ?');
mysqli_stmt_bind_param($find, 'i', $id);
mysqli_stmt_execute($find);
$product = mysqli_fetch_assoc(mysqli_stmt_get_result($find));
mysqli_stmt_close($find);
if (!$product) redirect_with_message('admin.php', 'Produk tidak ditemukan.');
$delete = mysqli_prepare($koneksi, 'DELETE FROM produk WHERE id_produk = ?');
mysqli_stmt_bind_param($delete, 'i', $id);
if (!mysqli_stmt_execute($delete)) redirect_with_message('admin.php', 'Produk gagal dihapus.');
mysqli_stmt_close($delete);
if (!empty($product['foto'])) { $filename = basename($product['foto']); $path = __DIR__ . '/assets/images/' . $filename; if (is_file($path)) @unlink($path); }
redirect_with_message('admin.php', 'Produk berhasil dihapus.');
?>