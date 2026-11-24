# Frozen Food App — Versi 2 (Teman)

Aplikasi web pencatatan produk frozen food dengan PHP Native, Bootstrap 5, dan MySQL/MariaDB (PDO).

## Fitur
- CRUD Produk (nama, harga, stok)
- CRUD Kategori
- CRUD Supplier
- Pengelompokan produk per kategori & supplier (dengan filter)

## Instalasi
1. Salin folder ke `htdocs`.
2. Import `database/schema.sql` dan `database/seed.sql` (database `db_frozen_food`).
3. Sesuaikan `config.php`.
4. Buka `http://localhost/index.php`.

## Struktur
```
frozen-food-app-teman/
├── index.php
├── config.php
├── includes/
├── assets/css/custom.css
├── produk/
├── kategori/
└── supplier/
```
