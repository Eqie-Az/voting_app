<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hanya admin yang boleh akses
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?url=KandidatController/index');
    exit;
}

// Base URL ke folder public
if (!defined('BASEURL')) {
    define('BASEURL', '../public/');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Kandidat</title>
    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css?v=<?= time(); ?>">
    <script src="<?= BASEURL ?>assets/js/script.js" defer></script>
</head>

<body>
    <div class="container">
        <h2>Tambah Kandidat</h2>

        <form action="index.php?url=KandidatController/simpan" method="POST" enctype="multipart/form-data">
            <label>Nama Ketua:</label>
            <input type="text" name="nama_ketua" required>

            <label>Nama Wakil:</label>
            <input type="text" name="nama_wakil" required>

            <label>Foto Kandidat:</label>
            <input type="file" name="foto" accept="image/*" required>

            <div style="margin-top: 30px; display: flex; align-items: center; gap: 15px;">
                <button type="submit">Simpan Data</button>

                <a href="index.php?url=KandidatController/index" class="btn-back">
                    <span class="icon">&larr;</span> Kembali
                </a>
            </div>
        </form>
    </div>
</body>

</html>