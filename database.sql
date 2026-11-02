CREATE DATABASE IF NOT EXISTS db_agribisnis
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_agribisnis;

CREATE TABLE IF NOT EXISTS produk (
  id_produk INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_produk VARCHAR(150) NOT NULL,
  harga INT UNSIGNED NOT NULL DEFAULT 0,
  stok INT UNSIGNED NOT NULL DEFAULT 0,
  deskripsi TEXT NOT NULL,
  foto VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id_produk),
  KEY idx_produk_nama (nama_produk)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS users (
  id_user INT UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(150) NOT NULL,
  PRIMARY KEY (id_user),
  UNIQUE KEY uq_users_username (username)
) ENGINE=InnoDB;