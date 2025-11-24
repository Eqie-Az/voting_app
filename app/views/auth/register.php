<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Register - Voting App</title>

    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css">
    <script src="<?= BASEURL ?>assets/js/script.js" defer></script>
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <form action="index.php?url=LoginController/prosesRegister" method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="index.php?url=LoginController/index" class="link">Login di sini</a></p>
    </div>

    <script src="/voting_app/public/assets/js/script.js" defer></script>
</body>

</html>