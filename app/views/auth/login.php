<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login - Voting App</title>

    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css?v=<?= time(); ?>">
    <script src="<?= BASEURL ?>assets/js/script.js" defer></script>
</head>

<body>
    <div class="container" style="max-width: 450px;">
        <h2>Login</h2>
        <form action="index.php?url=LoginController/prosesLogin" method="POST">
            <label>Email:</label>
            <input type="email" name="email" placeholder="Masukkan email Anda" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Masukkan password" required>

            <button type="submit" style="width: 100%; margin-top: 10px;">Login Masuk</button>
        </form>
        <!-- Auth Footer Elegan -->
        <div class="auth-footer">
            <span>Belum punya akun?</span>
            <a href="index.php?url=LoginController/register" class="btn-outline">Daftar Sekarang</a>
        </div>
    </div>
</body>

</html>