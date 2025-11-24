<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class KandidatController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=LoginController/index');
            exit;
        }

        $model = $this->model('Kandidat');
        $data = $model->getAll();

        $this->view('kandidat/index', ['kandidat' => $data]);
    }

    public function tambah()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?url=KandidatController/index');
            exit;
        }

        $this->view('kandidat/tambah');
    }

    public function simpan()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?url=KandidatController/index');
            exit;
        }

        $nama_ketua = $_POST['nama_ketua'] ?? '';
        $nama_wakil = $_POST['nama_wakil'] ?? '';
        $foto = null;

        // 🔹 Proses upload foto baru
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $targetDir = __DIR__ . '/../../public/assets/img/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $foto = time() . '_' . uniqid() . '.' . $ext;
                $targetFile = $targetDir . $foto;

                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                    error_log('❌ Gagal memindahkan file ke ' . $targetFile);
                    $foto = null;
                }
            } else {
                error_log('❌ Ekstensi file tidak diizinkan: ' . $ext);
                $foto = null;
            }
        }

        // 🔹 Simpan ke database
        $model = $this->model('Kandidat');
        $model->add($nama_ketua, $nama_wakil, $foto);

        header('Location: index.php?url=KandidatController/index');
        exit;
    }

    public function edit($id = null)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?url=LoginController/index');
            exit;
        }

        if ($id === null) {
            echo "ID kandidat tidak ditemukan.";
            return;
        }

        $model = $this->model('Kandidat');
        $data = $model->getById($id);

        if (!$data) {
            echo "Kandidat tidak ditemukan.";
            return;
        }

        $this->view('kandidat/edit', ['kandidat' => $data]);
    }

    public function update($id = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?url=LoginController/index');
            exit;
        }

        if ($id === null) {
            echo "ID kandidat tidak ditemukan.";
            return;
        }

        $model = $this->model('Kandidat');
        $nama_ketua = $_POST['nama_ketua'] ?? '';
        $nama_wakil = $_POST['nama_wakil'] ?? '';
        $foto = null;

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $targetDir = __DIR__ . '/../../public/assets/img/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $foto = time() . '_' . uniqid() . '.' . $ext;
                $targetFile = $targetDir . $foto;

                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                    error_log('❌ Gagal memindahkan file ke ' . $targetFile);
                    $foto = null;
                }
            } else {
                error_log('❌ Ekstensi file tidak diizinkan: ' . $ext);
                $foto = null;
            }
        }

        $model->update($id, $nama_ketua, $nama_wakil, $foto);

        header('Location: index.php?url=KandidatController/index');
        exit;
    }

    public function hapus($id = null)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?url=LoginController/index');
            exit;
        }

        if ($id === null) {
            echo "ID kandidat tidak ditemukan.";
            return;
        }

        $model = $this->model('Kandidat');
        $model->delete($id); // Ubah ke delete agar sesuai dengan model

        header('Location: index.php?url=KandidatController/index');
        exit;
    }
}
?>