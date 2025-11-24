<?php
// Pastikan session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user login dan ambil role
$isLoggedIn = isset($_SESSION['user']);
$isAdmin = $isLoggedIn && $_SESSION['user']['role'] === 'admin';
$email = $isLoggedIn ? htmlspecialchars($_SESSION['user']['email']) : '';
$username = $isLoggedIn ? htmlspecialchars($_SESSION['user']['username']) : ''; // 🔹 Tambahan untuk username

// Definisikan BASEURL untuk akses folder public
if (!defined('BASEURL')) {
    define('BASEURL', 'http://voting_app.test/voting_app/public/');
}

// Definisikan ASSETURL sesuai lokasi upload foto kandidat
if (!defined('ASSETURL')) {
    define('ASSETURL', BASEURL . 'assets/img/');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Kandidat</title>
    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2>Daftar Kandidat</h2>

            <?php if ($isLoggedIn): ?>
                <div style="text-align:right;">
                    <span style="font-size:14px; color:#555; margin-right:10px;">
                        <?= $username; ?> (<?= ucfirst($_SESSION['user']['role']); ?>)
                    </span>
                    <a href="index.php?url=LoginController/logout" class="button" style="background:#e74c3c;">Logout</a>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($isAdmin): ?>
            <div style="text-align: right; margin-bottom: 20px;">
                <a href="index.php?url=KandidatController/tambah" class="button">+ Tambah Kandidat</a>
            </div>
        <?php endif; ?>

        <?php if (!empty($data['kandidat'])): ?>
            <?php foreach ($data['kandidat'] as $k): ?>
                <div class="kandidat-card">
                    <?php
                    // Jika foto kosong, gunakan default.jpg
                    $foto = !empty($k['foto']) ? htmlspecialchars($k['foto']) : 'default.jpg';
                    ?>

                    <!-- Foto Kandidat -->
                    <img src="<?= ASSETURL . $foto; ?>" alt="Foto Kandidat">

                    <!-- Nama Ketua & Wakil -->
                    <strong>
                        <?= htmlspecialchars($k['nama_ketua'] ?? 'Tidak diketahui'); ?> &
                        <?= htmlspecialchars($k['nama_wakil'] ?? 'Tidak diketahui'); ?>
                    </strong>

                    <!-- Tombol Aksi -->
                    <?php if ($isAdmin): ?>
                        <div style="margin-top:10px;">
                            <a href="index.php?url=KandidatController/edit/<?= $k['id']; ?>" class="button"
                                style="background:#3498db;">Edit</a>
                            <a href="index.php?url=KandidatController/hapus/<?= $k['id']; ?>" class="button"
                                style="background:#e74c3c;"
                                onclick="return confirm('Yakin ingin menghapus kandidat ini?')">Hapus</a>
                        </div>
                    <?php else: ?>
                        <div style="margin-top:10px;">
                            <a href="index.php?url=VoteController/vote/<?= $k['id']; ?>" class="button"
                                style="background:#2ecc71;">Vote</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;">Belum ada kandidat yang tersedia.</p>
        <?php endif; ?>

        <!-- Tombol hasil voting dan aktivitas login (khusus admin) -->
        <?php if ($isAdmin): ?>
            <div style="display: flex; justify-content: center; gap: 10px; margin-top:20px;">
                <a href="index.php?url=HasilController/hasil" class="button" style="background:#27ae60;">Lihat Hasil
                    Voting</a>
                <a href="index.php?url=LogController/index" class="button" style="background:#f39c12;">Lihat Aktivitas
                    Login</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>