<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASEURL')) {
    define('BASEURL', 'http://voting_app.test/voting_app/public/');
}

// Hanya admin yang bisa melihat halaman hasil
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo "<h3 style='text-align:center; color:red; margin-top:50px;'>⚠️ Akses ditolak! Hanya admin yang dapat melihat halaman hasil voting.</h3>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Voting</title>
    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css?v=<?= time(); ?>">
</head>

<body>
    <div class="container">
        <h2>📊 Hasil Voting</h2>

        <?php if (!empty($data['kandidat'])): ?>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="text-align:center;">Foto</th>
                            <th>Nama Ketua & Wakil</th>
                            <th style="text-align:center;">Jumlah Suara</th>
                            <th style="text-align:center;">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['kandidat'] as $k):
                            ?>
                            <tr>
                                <td style="text-align:center;"><?= $no++; ?></td>
                                <td style="text-align:center;">
                                    <img src="<?= BASEURL ?>assets/img/<?= htmlspecialchars($k['foto']); ?>"
                                        alt="Foto <?= htmlspecialchars($k['nama_ketua']); ?>" class="table-avatar">
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($k['nama_ketua']); ?></strong><br>
                                    <small style="color:#666;">&amp; <?= htmlspecialchars($k['nama_wakil']); ?></small>
                                </td>
                                <td style="text-align:center;"><?= htmlspecialchars($k['jumlah_suara']); ?></td>
                                <td style="text-align:center;"><strong><?= $k['persentase']; ?>%</strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <p style="text-align:center; margin: 20px 0; font-size: 1.1em; color: #555;">
                Total Suara Masuk: <strong><?= $data['totalSuara']; ?></strong>
            </p>

            <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

            <div class="chart-container">
                <h3 style="text-align:center; margin-bottom:30px;">Grafik Perolehan</h3>

                <?php foreach ($data['kandidat'] as $k): ?>
                    <div class="bar-wrapper">
                        <div class="bar-label">
                            <span><?= htmlspecialchars($k['nama_ketua']); ?></span>
                            <span><?= $k['persentase']; ?>%</span>
                        </div>

                        <div class="bar">
                            <div class="bar-fill" style="width: <?= $k['persentase']; ?>%;"></div>
                        </div>

                        <div class="total-votes">
                            <?= $k['jumlah_suara']; ?> Suara
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div style="text-align:center; padding: 40px;">
                <p>Belum ada hasil voting yang masuk.</p>
            </div>
        <?php endif; ?>

        <div style="text-align:center; margin-top:40px;">
            <a href="index.php?url=KandidatController/index" class="button">
                &larr; Kembali ke Daftar Kandidat
            </a>
        </div>
    </div>

    <script src="<?= BASEURL ?>assets/js/script.js?v=<?= time(); ?>"></script>
</body>

</html>