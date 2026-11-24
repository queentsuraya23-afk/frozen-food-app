<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Tambah Supplier';

$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim((string) ($_POST['nama_supplier'] ?? ''));
    if ($nama === '') {
        $errorMessages[] = 'Nama supplier wajib diisi.';
    }
    if (count($errorMessages) > 0) {
        set_flash('error', implode(' · ', $errorMessages));
    } else {
        $stmt = $pdo->prepare('INSERT INTO supplier (nama_supplier) VALUES (:nama)');
        $stmt->execute([':nama' => $nama]);
        set_flash('success', 'Supplier ' . $nama . ' berhasil ditambahkan.');
        redirect('/supplier/index.php');
    }
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <h1 class="h3 mb-3">Tambah Supplier</h1>
        <div class="card">
            <div class="card-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="nama_supplier" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" required>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="/supplier/index.php" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
