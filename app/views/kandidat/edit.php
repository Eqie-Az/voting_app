<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Kandidat</title>
    <link rel="stylesheet" href="<?= BASEURL ?>assets/css/style.css?v=<?= time(); ?>">
    <script src="<?= BASEURL ?>assets/js/script.js" defer></script>
</head>

<body>
    <div class="container">
        <h2>Edit Kandidat</h2>
        <form action="index.php?url=KandidatController/update/<?= $data['kandidat']['id']; ?>" method="POST"
            enctype="multipart/form-data">

            <label>Nama Ketua:</label>
            <input type="text" name="nama_ketua" value="<?= htmlspecialchars($data['kandidat']['nama_ketua']) ?>"
                required>

            <label>Nama Wakil:</label>
            <input type="text" name="nama_wakil" value="<?= htmlspecialchars($data['kandidat']['nama_wakil']) ?>"
                required>

            <p>Foto Saat Ini:</p>
            <img src="<?= BASEURL ?>assets/img/<?= $data['kandidat']['foto'] ?>" width="150"
                style="border-radius:10px; margin-bottom: 10px;"><br>

            <label>Ganti Foto (opsional):</label>
            <input type="file" name="foto" accept="image/*">

            <div style="margin-top: 30px; display: flex; align-items: center; gap: 15px;">
                <button type="submit">Update Data</button>

                <a href="index.php?url=KandidatController/index" class="btn-back">
                    <span class="icon">&larr;</span> Batal & Kembali
                </a>
            </div>
        </form>
    </div>
</body>

</html>