<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Produk';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare('DELETE FROM produk WHERE id = :id');
        $stmt->execute([':id' => $id]);
        set_flash('success', 'Produk berhasil dihapus.');
    }
    redirect('/produk/index.php');
}

$keyword = trim((string) ($_GET['q'] ?? ''));
$kategoriId = (int) ($_GET['kategori_id'] ?? 0);
$supplierId = (int) ($_GET['supplier_id'] ?? 0);

$sql = 'SELECT p.*, k.nama_kategori, s.nama_supplier FROM produk p '
    . 'JOIN kategori k ON k.id = p.kategori_id '
    . 'JOIN supplier s ON s.id = p.supplier_id';
$where = [];
$params = [];
if ($kategoriId > 0) {
    $where[] = 'p.kategori_id = :kategori_id';
    $params['kategori_id'] = $kategoriId;
}
if ($supplierId > 0) {
    $where[] = 'p.supplier_id = :supplier_id';
    $params['supplier_id'] = $supplierId;
}
if ($keyword !== '') {
    $where[] = 'p.nama_produk LIKE :like_nama';
    $params['like_nama'] = '%' . $keyword . '%';
}
if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY p.id DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produkList = $stmt->fetchAll();

$kategoriList = $pdo->query('SELECT id, nama_kategori FROM kategori ORDER BY id ASC')->fetchAll();
$supplierList = $pdo->query('SELECT id, nama_supplier FROM supplier ORDER BY id ASC')->fetchAll();
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Daftar Produk</h1>
    <a href="/produk/create.php" class="btn btn-primary">+ Tambah Produk</a>
</div>

<div class="card mt-3">
    <div class="card-body">
        <form method="get" action="/produk/index.php" class="row g-2">
            <div class="col-md-4">
                <input type="search" name="q" value="<?= e($keyword) ?>" class="form-control" placeholder="Cari produk...">
            </div>
            <div class="col-md-3">
                <select name="kategori_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategoriList as $k): ?>
                        <option value="<?= (int) $k['id'] ?>"<?= $kategoriId === (int) $k['id'] ? ' selected' : '' ?>><?= e($k['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="supplier_id" class="form-select">
                    <option value="">Semua Supplier</option>
                    <?php foreach ($supplierList as $s): ?>
                        <option value="<?= (int) $s['id'] ?>"<?= $supplierId === (int) $s['id'] ? ' selected' : '' ?>><?= e($s['nama_supplier']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Supplier</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($produkList) > 0): ?>
                    <?php foreach ($produkList as $row): ?>
                        <tr>
                            <td><?= (int) $row['id'] ?></td>
                            <td class="fw-semibold"><?= e($row['nama_produk']) ?></td>
                            <td><span class="badge bg-primary rounded-pill"><?= e($row['nama_kategori']) ?></span></td>
                            <td><?= e($row['nama_supplier']) ?></td>
                            <td>Rp <?= e(number_format((float) $row['harga'], 0, ',', '.')) ?></td>
                            <td><?= (int) $row['stok'] ?></td>
                            <td>
                                <a href="/produk/edit.php?id=<?= (int) $row['id'] ?>" class="btn btn-sm btn-outline-primary">Ubah</a>
                                <form method="post" action="/produk/index.php" class="d-inline" onsubmit="return confirm('Hapus produk ini?');">
                                    <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada produk yang tercatat.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
