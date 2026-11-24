<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Beranda';

$totalProduk = (int) $pdo->query('SELECT COUNT(*) FROM produk')->fetchColumn();
$totalKategori = (int) $pdo->query('SELECT COUNT(*) FROM kategori')->fetchColumn();
$totalSupplier = (int) $pdo->query('SELECT COUNT(*) FROM supplier')->fetchColumn();

$produkTerbaru = $pdo->query(
    'SELECT p.*, k.nama_kategori, s.nama_supplier FROM produk p '
    . 'JOIN kategori k ON k.id = p.kategori_id '
    . 'JOIN supplier s ON s.id = p.supplier_id '
    . 'ORDER BY p.id DESC LIMIT 5'
)->fetchAll();
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<div class="py-5">
    <div class="container">
        <div class="p-5 mb-4 bg-primary text-white rounded-4 shadow">
            <h1 class="display-5 fw-bold">Frozen Food Manager</h1>
            <p class="lead mb-0">Catat produk frozen food, kelola kategori, dan susun supplier — dengan rapi.</p>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="card stat-card h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon">📦</div>
                        <div>
                            <h4 class="mb-0"><?= $totalProduk ?></h4>
                            <span class="text-muted">Produk</span>
                        </div>
                    </div>
                    <a class="btn btn-primary mt-3 w-100" href="/produk/index.php">Lihat Produk</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon">🗂️</div>
                        <div>
                            <h4 class="mb-0"><?= $totalKategori ?></h4>
                            <span class="text-muted">Kategori</span>
                        </div>
                    </div>
                    <a class="btn btn-primary mt-3 w-100" href="/kategori/index.php">Lihat Kategori</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon">🚚</div>
                        <div>
                            <h4 class="mb-0"><?= $totalSupplier ?></h4>
                            <span class="text-muted">Supplier</span>
                        </div>
                    </div>
                    <a class="btn btn-primary mt-3 w-100" href="/supplier/index.php">Lihat Supplier</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white fw-semibold">Produk Terbaru</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($produkTerbaru as $p): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><?= e($p['nama_produk']) ?></span>
                                <span class="badge bg-primary rounded-pill"><?= e($p['nama_kategori']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="card-footer">
                    <a class="btn btn-outline-primary btn-sm" href="/produk/index.php">Kelola Semua Produk</a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white fw-semibold">Ringkasan Bisnis</div>
                <div class="card-body">
                    <p class="mb-2">Catat stok produk frozen food, kelompokkan per kategori, dan filter per supplier.</p>
                    <p class="mb-2">Gunakan fitur filter di halaman Produk untuk menampilkan produk per kategori atau supplier.</p>
                    <a class="btn btn-outline-primary btn-sm" href="/produk/index.php">Buka Katalog Produk</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
