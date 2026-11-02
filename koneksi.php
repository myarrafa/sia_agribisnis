<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db_name = 'db_agribisnis';

$koneksi = mysqli_connect($host, $user, $password, $db_name);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');
?>