<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASEURL')) {
    define('BASEURL', '../public/');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sudah Voting</title>
    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css">
</head>

<body>
    <div class="container" style="text-align:center; margin-top:60px;">
        <h2>Anda sudah melakukan voting!</h2>
        <p style="margin-top:10px;">
            Suara Anda telah kami catat. Anda tidak dapat melakukan voting lebih dari satu kali.
        </p>

        <div style="margin-top:30px;">
            <a href="index.php?url=LoginController/logout" class="button" style="background:#e74c3c;">
                Logout
            </a>
        </div>
    </div>
</body>

</html>