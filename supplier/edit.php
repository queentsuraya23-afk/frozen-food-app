<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Ubah Supplier';

$id = (int) ($_GET['id'] ?? 0);
$row = null;
if ($id > 0) {
    $stmt = $pdo->prepare('SELECT * FROM supplier WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
}

$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim((string) ($_POST['nama_supplier'] ?? ''));
    if ($nama === '') {
        $errorMessages[] = 'Nama supplier wajib diisi.';
    }
    if (count($errorMessages) > 0) {
        set_flash('error', implode(' · ', $errorMessages));
    } else {
        $stmt = $pdo->prepare('UPDATE supplier SET nama_supplier = :nama WHERE id = :id');
        $stmt->execute([':nama' => $nama, ':id' => $id]);
        set_flash('success', 'Supplier berhasil diperbarui.');
        redirect('/supplier/index.php');
    }
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <h1 class="h3 mb-3">Ubah Supplier</h1>
        <?php if ($row === null): ?>
            <div class="alert alert-warning">Supplier tidak ditemukan.</div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                        <div class="mb-3">
                            <label for="nama_supplier" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" value="<?= e($row['nama_supplier']) ?>" required>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="/supplier/index.php" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
