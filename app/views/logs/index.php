<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user login dan ambil role
$isLoggedIn = isset($_SESSION['user']);
$isAdmin = $isLoggedIn && $_SESSION['user']['role'] === 'admin';

// Definisikan BASEURL
if (!defined('BASEURL')) {
    define('BASEURL', 'http://voting_app.test/voting_app/public/');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Log Aktivitas</title>
    <!-- Memuat CSS utama -->
    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css?v=<?= time(); ?>">
</head>

<body>
    <!-- Container lebar khusus logs -->
    <div class="container container-wide">
        <h2>📜 Log Aktivitas Pengguna</h2>

        <!-- Toolbar Aksi -->
        <div class="actions-toolbar">
            <a href="<?= BASEURL ?>index.php?url=KandidatController/index" class="btn-back">
                <span class="icon">&larr;</span> Kembali ke Kandidat
            </a>
        </div>

        <!-- Tabel Logs -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th>User (ID)</th>
                        <th>Email Pengguna</th>
                        <th>Aksi</th>
                        <th>Waktu</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($logs) && is_array($logs) && count($logs) > 0): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($log['id']) ?></td>

                                <td>
                                    <strong><?= htmlspecialchars($log['username'] ?? 'Unknown') ?></strong>
                                    <br>
                                    <small class="text-muted-small">ID: <?= htmlspecialchars($log['user_id']) ?></small>
                                </td>

                                <td>
                                    <?= htmlspecialchars($log['email'] ?? '-') ?>
                                </td>

                                <td>
                                    <span class="badge-action">
                                        <?= htmlspecialchars($log['action']) ?>
                                    </span>
                                </td>

                                <td class="text-timestamp">
                                    <?= htmlspecialchars($log['timestamp']) ?>
                                </td>

                                <td class="font-mono">
                                    <?= htmlspecialchars($log['ip_address']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="empty-log">
                                <p>Belum ada data log aktivitas.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>