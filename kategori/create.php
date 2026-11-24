<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Tambah Kategori';

$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim((string) ($_POST['nama_kategori'] ?? ''));
    if ($nama === '') {
        $errorMessages[] = 'Nama kategori wajib diisi.';
    }
    if (count($errorMessages) > 0) {
        set_flash('error', implode(' · ', $errorMessages));
    } else {
        $stmt = $pdo->prepare('INSERT INTO kategori (nama_kategori) VALUES (:nama)');
        $stmt->execute([':nama' => $nama]);
        set_flash('success', 'Kategori ' . $nama . ' berhasil ditambahkan.');
        redirect('/kategori/index.php');
    }
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <h1 class="h3 mb-3">Tambah Kategori</h1>
        <div class="card">
            <div class="card-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="/kategori/index.php" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
