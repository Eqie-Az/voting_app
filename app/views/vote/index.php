<?php
// Pastikan session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user login
$isLoggedIn = isset($_SESSION['user']);
$email = $isLoggedIn ? htmlspecialchars($_SESSION['user']['email']) : '';

// Definisikan BASEURL dan ASSETURL (sama seperti halaman kandidat)
if (!defined('BASEURL')) {
    define('BASEURL', 'http://voting_app.test/voting_app/public/');
}

if (!defined('ASSETURL')) {
    define('ASSETURL', BASEURL . 'assets/img/');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Voting Kandidat</title>
    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2>Pilih Kandidat</h2>

            <?php if ($isLoggedIn): ?>
                <div style="text-align:right;">
                    <span style="font-size:14px; color:#555; margin-right:10px;">
                        <?= $email; ?> (User)
                    </span>
                    <a href="index.php?url=LoginController/logout" class="button" style="background:#e74c3c;">Logout</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Daftar Kandidat -->
        <?php if (!empty($data['kandidat'])): ?>
            <div class="kandidat-list">
                <?php foreach ($data['kandidat'] as $k): ?>
                    <div class="kandidat-card">
                        <?php
                        $foto = !empty($k['foto']) ? htmlspecialchars($k['foto']) : 'default.jpg';
                        ?>
                        <img src="<?= ASSETURL . $foto; ?>" alt="Foto Kandidat">

                        <strong>
                            <?= htmlspecialchars($k['nama_ketua'] ?? 'Tidak diketahui'); ?> &
                            <?= htmlspecialchars($k['nama_wakil'] ?? 'Tidak diketahui'); ?>
                        </strong>

                        <div style="margin-top:10px;">
                            <a href="index.php?url=VoteController/vote/<?= $k['id']; ?>" class="button"
                                style="background:#2ecc71;">Vote</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align:center;">Belum ada kandidat yang tersedia untuk dipilih.</p>
        <?php endif; ?>

        <!-- Tombol kembali -->
        <div style="text-align:center; margin-top:25px;">
            <a href="index.php?url=KandidatController/index" class="button" style="background:#3498db;">
                Kembali ke Daftar Kandidat
            </a>
        </div>
    </div>
</body>

</html>
