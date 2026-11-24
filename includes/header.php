<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = (string) ($pageTitle ?? 'Beranda');

$scriptUri = parse_url((string) ($_SERVER['PHP_SELF'] ?? '/index.php'), PHP_URL_PATH);
if ($scriptUri === null) {
    $scriptUri = '/';
}
$currentPage = 'index.php';
if (strpos($scriptUri, '/produk/') !== false) {
    $currentPage = 'produk';
} elseif (strpos($scriptUri, '/kategori/') !== false) {
    $currentPage = 'kategori';
} elseif (strpos($scriptUri, '/supplier/') !== false) {
    $currentPage = 'supplier';
}

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> · Frozen Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/custom.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/index.php">FrozenFood</a>
        <div class="navbar-nav">
            <a class="nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>" href="/index.php">Beranda</a>
            <a class="nav-link <?= $currentPage === 'produk' ? 'active' : '' ?>" href="/produk/index.php">Produk</a>
            <a class="nav-link <?= $currentPage === 'kategori' ? 'active' : '' ?>" href="/kategori/index.php">Kategori</a>
            <a class="nav-link <?= $currentPage === 'supplier' ? 'active' : '' ?>" href="/supplier/index.php">Supplier</a>
        </div>
    </div>
</nav>

<main class="container">
<?php if ($flash !== null): ?>
    <div class="alert alert-<?= htmlspecialchars((string) $flash['type']) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars((string) $flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
