<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login - Voting App</title>

    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css">
    <script src="<?= BASEURL ?>assets/js/script.js" defer></script>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form action="index.php?url=LoginController/prosesLogin" method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p>Belum punya akun? <a href="index.php?url=LoginController/register" class="link">Daftar di sini</a></p>
    </div>

    <!-- PATH ABSOLUT ke js -->
    <script src="/assets/js/script.js" defer></script>
</body>

</html>