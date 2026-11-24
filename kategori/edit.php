<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Ubah Kategori';

$id = (int) ($_GET['id'] ?? 0);
$row = null;
if ($id > 0) {
    $stmt = $pdo->prepare('SELECT * FROM kategori WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
}

$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim((string) ($_POST['nama_kategori'] ?? ''));
    if ($nama === '') {
        $errorMessages[] = 'Nama kategori wajib diisi.';
    }
    if (count($errorMessages) > 0) {
        set_flash('error', implode(' · ', $errorMessages));
    } else {
        $stmt = $pdo->prepare('UPDATE kategori SET nama_kategori = :nama WHERE id = :id');
        $stmt->execute([':nama' => $nama, ':id' => $id]);
        set_flash('success', 'Kategori berhasil diperbarui.');
        redirect('/kategori/index.php');
    }
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <h1 class="h3 mb-3">Ubah Kategori</h1>
        <?php if ($row === null): ?>
            <div class="alert alert-warning">Kategori tidak ditemukan.</div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= e($row['nama_kategori']) ?>" required>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="/kategori/index.php" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
