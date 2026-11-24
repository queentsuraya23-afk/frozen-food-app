-- ============================================================
-- Kulkas — Sistem Pencatatan Produk Frozen Food
-- Skema database: tabel produk, kategori, dan supplier
-- dengan relasi foreign key
-- ============================================================

CREATE DATABASE IF NOT EXISTS db_frozen_food CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_frozen_food;

CREATE TABLE kategori (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_kategori_nama UNIQUE (nama_kategori)
);

CREATE TABLE supplier (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(150) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE produk (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(150) NOT NULL,
    kategori_id INT UNSIGNED NOT NULL,
    supplier_id INT UNSIGNED NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    stok INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_produk_kategori FOREIGN KEY (kategori_id) REFERENCES kategori (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_produk_supplier FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE RESTRICT ON UPDATE CASCADE
);
