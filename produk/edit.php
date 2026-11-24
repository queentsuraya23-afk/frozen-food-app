<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Ubah Produk';

$id = (int) ($_GET['id'] ?? 0);
$row = null;
$kategoriList = $pdo->query('SELECT id, nama_kategori FROM kategori ORDER BY id ASC')->fetchAll();
$supplierList = $pdo->query('SELECT id, nama_supplier FROM supplier ORDER BY id ASC')->fetchAll();
if ($id > 0) {
    $stmt = $pdo->prepare('SELECT * FROM produk WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
}

$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim((string) ($_POST['nama_produk'] ?? ''));
    $kategoriId = (int) ($_POST['kategori_id'] ?? 0);
    $supplierId = (int) ($_POST['supplier_id'] ?? 0);
    $harga = trim((string) ($_POST['harga'] ?? ''));
    $stok = trim((string) ($_POST['stok'] ?? ''));

    if ($nama === '') {
        $errorMessages[] = 'Nama produk wajib diisi.';
    }
    if ($kategoriId <= 0) {
        $errorMessages[] = 'Kategori wajib dipilih.';
    }
    if ($supplierId <= 0) {
        $errorMessages[] = 'Supplier wajib dipilih.';
    }
    if (!is_numeric($harga) || (float) $harga <= 0) {
        $errorMessages[] = 'Harga harus berupa angka yang valid dan lebih besar dari 0.';
    }
    if (!is_numeric($stok) || (int) $stok < 0) {
        $errorMessages[] = 'Stok harus berupa angka yang valid dan tidak boleh negatif.';
    }

    if (count($errorMessages) > 0) {
        set_flash('error', implode(' · ', $errorMessages));
    } else {
        $stmt = $pdo->prepare(
            'UPDATE produk SET nama_produk = :nama, kategori_id = :kategori, supplier_id = :supplier, harga = :harga, stok = :stok WHERE id = :id'
        );
        $stmt->execute([
            ':nama' => $nama,
            ':kategori' => $kategoriId,
            ':supplier' => $supplierId,
            ':harga' => (float) $harga,
            ':stok' => (int) $stok,
            ':id' => $id,
        ]);
        set_flash('success', 'Produk berhasil diperbarui.');
        redirect('/produk/index.php');
    }
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <h1 class="h3 mb-3">Ubah Produk</h1>
        <?php if ($row === null): ?>
            <div class="alert alert-warning">Produk tidak ditemukan.</div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= e($row['nama_produk']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih kategori...</option>
                                <?php foreach ($kategoriList as $k): ?>
                                    <option value="<?= (int) $k['id'] ?>"<?= (int) $row['kategori_id'] === (int) $k['id'] ? ' selected' : '' ?>><?= e($k['nama_kategori']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select class="form-select" id="supplier_id" name="supplier_id" required>
                                <option value="">Pilih supplier...</option>
                                <?php foreach ($supplierList as $s): ?>
                                    <option value="<?= (int) $s['id'] ?>"<?= (int) $row['supplier_id'] === (int) $s['id'] ? ' selected' : '' ?>><?= e($s['nama_supplier']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" min="0" step="0.01" value="<?= e($row['harga']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" min="0" step="1" value="<?= e($row['stok']) ?>" required>
                            </div>
                        </div>
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="/produk/index.php" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
