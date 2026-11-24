<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Kategori';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM produk WHERE kategori_id = :id');
        $stmt->execute([':id' => $id]);
        $usedCount = (int) $stmt->fetchColumn();
        if ($usedCount > 0) {
            set_flash('error', 'Kategori masih digunakan oleh produk, tidak dapat dihapus.');
        } else {
            $stmt = $pdo->prepare('DELETE FROM kategori WHERE id = :id');
            $stmt->execute([':id' => $id]);
            set_flash('success', 'Kategori berhasil dihapus.');
        }
    }
    redirect('/kategori/index.php');
}

$keyword = trim((string) ($_GET['q'] ?? ''));
$sql = 'SELECT k.*, (SELECT COUNT(*) FROM produk p WHERE p.kategori_id = k.id) AS jumlah_produk FROM kategori k';
$where = [];
$params = [];
if ($keyword !== '') {
    $where[] = '(k.nama_kategori LIKE :like_nama)';
    $params['like_nama'] = '%' . $keyword . '%';
}
if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY k.id ASC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$kategoriList = $stmt->fetchAll();
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Daftar Kategori</h1>
    <a href="/kategori/create.php" class="btn btn-primary">+ Tambah Kategori</a>
</div>

<div class="card mt-3">
    <div class="card-body">
        <form method="get" action="/kategori/index.php" class="row g-2">
            <div class="col-md-8">
                <input type="search" name="q" value="<?= e($keyword) ?>" class="form-control" placeholder="Cari kategori...">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
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
                        <th>Nama Kategori</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($kategoriList) > 0): ?>
                    <?php foreach ($kategoriList as $row): ?>
                        <tr>
                            <td><?= (int) $row['id'] ?></td>
                            <td class="fw-semibold"><?= e($row['nama_kategori']) ?></td>
                            <td><span class="badge bg-primary rounded-pill"><?= (int) $row['jumlah_produk'] ?> produk</span></td>
                            <td>
                                <a href="/kategori/edit.php?id=<?= (int) $row['id'] ?>" class="btn btn-sm btn-outline-primary">Ubah</a>
                                <form method="post" action="/kategori/index.php" class="d-inline" onsubmit="return confirm('Hapus kategori ini?');">
                                    <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada kategori yang tercatat.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
