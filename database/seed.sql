-- Data awal (seed) untuk aplikasi Kulkas — Produk Frozen Food
USE db_frozen_food;

INSERT INTO kategori (nama_kategori) VALUES
('Frozen Seafood'),
('Frozen Vegetables'),
('Frozen Meat');

INSERT INTO supplier (nama_supplier) VALUES
('PT Laut Segar Nusantara'),
('Frozen Prima Indonesia'),
('Sumber Protein Abadi');

INSERT INTO produk (nama_produk, kategori_id, supplier_id, harga, stok) VALUES
('Frozen Ikan Tuna Segar', 1, 1, 85000, 24),
('Frozen Cumi-cumi Segar', 1, 1, 45000, 40),
('Frozen Krustasea Udang', 1, 2, 62000, 18),
('Frozen Fish Ball', 1, 1, 12000, 80),
('Frozen Sayuran Campur', 2, 2, 22000, 60),
('Frozen Brokoli Dingin', 2, 2, 15000, 45),
('Frozen Superfood Sayuran', 2, 2, 26000, 30),
('Frozen Ayam Goreng', 3, 3, 26000, 35),
('Frozen Daging Sapi Segmentur', 3, 3, 95000, 12),
('Frozen Sosis Ayam', 3, 3, 28000, 50),
('Frozen Bakso Daging', 3, 3, 24000, 55);
