<?php
if (!defined('BASEURL')) {
    define('BASEURL', 'http://voting_app.test/voting_app/public/');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Suara</title>
    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css?v=<?= time(); ?>">
</head>

<body>
    <!-- Menggunakan .container-xs untuk ukuran kecil dan text-center -->
    <div class="container container-xs">

        <h2>🔒 Konfirmasi Suara</h2>

        <!-- Alert Box -->
        <div class="alert-warning">
            <p>Suara Anda telah disimpan sebagai <strong>PENDING</strong>.</p>
            <p class="small-info">Silakan tekan tombol di bawah untuk mensahkan suara Anda agar masuk dalam perhitungan.
            </p>
        </div>

        <!-- Form untuk mensahkan suara -->
        <form action="index.php?url=VoteController/prosesVerifikasi" method="POST">
            <button type="submit" class="button btn-large">
                ✅ Sahkan Suara Saya
            </button>
        </form>

        <p class="text-hint">
            Langkah ini diperlukan untuk memastikan keaslian pemilih.
        </p>
    </div>
</body>

</html>