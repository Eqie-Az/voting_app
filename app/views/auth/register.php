<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Register - Voting App</title>

    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css?v=<?= time(); ?>">
    <script src="<?= BASEURL ?>assets/js/script.js" defer></script>
</head>

<body>
    <div class="container" style="max-width: 450px;">
        <h2>Register</h2>

        <form action="index.php?url=LoginController/prosesRegister" method="POST">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Nama Lengkap" required>

            <label>Email:</label>
            <input type="email" name="email" placeholder="email@contoh.com" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Buat password" required>

            <button type="submit" style="width: 100%; margin-top: 10px;">Daftar Akun</button>
        </form>

        <!-- Auth Footer Elegan -->
        <div class="auth-footer">
            <span>Sudah punya akun?</span>
            <a href="index.php?url=LoginController/index" class="btn-outline">Login di sini</a>
        </div>
    </div>
</body>

</html>