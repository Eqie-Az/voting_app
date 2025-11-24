<?php
class LoginController extends Controller
{
    public function index()
    {
        session_start();
        // Jika sudah login, langsung arahkan sesuai role
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $voteModel = $this->model('Vote');

            if ($user['role'] === 'admin') {
                header('Location: index.php?url=KandidatController/index');
                exit;
            } elseif ($user['role'] === 'user') {
                // Selalu cek ulang ke database, bukan dari session lama
                if ($voteModel->sudahVote($user['id'])) {
                    header('Location: index.php?url=VoteController/sudah');
                    exit;
                } else {
                    header('Location: index.php?url=KandidatController/index');
                    exit;
                }
            }
        }

        // Jika belum login, tampilkan halaman login
        $this->view('auth/login');
    }

    public function prosesLogin()
    {
        session_start();
        require_once __DIR__ . '/../../config/koneksi.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Cek user dari database
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Pastikan session bersih dari data lama
            $_SESSION = [];
            session_unset();

            // Set session user baru
            $_SESSION['user'] = $user;

            // Hapus status voting lama jika ada
            unset($_SESSION['sudah_vote']);

            // ============================================================
            // [BARU] CATAT LOG LOGIN
            // ============================================================
            // Kita panggil model Log untuk mencatat bahwa user ini baru saja login.
            // Data email nanti otomatis terambil lewat user_id di model Log.
            $logModel = $this->model('Log');
            $ip_address = $_SERVER['REMOTE_ADDR']; // Ambil IP Address user
            $logModel->logAction($user['id'], 'Login Masuk', $ip_address);
            // ============================================================

            $voteModel = $this->model('Vote');

            // Arahkan sesuai role dan status voting real-time
            if ($user['role'] === 'admin') {
                header('Location: index.php?url=KandidatController/index');
            } elseif ($user['role'] === 'user') {
                if ($voteModel->sudahVote($user['id'])) {
                    header('Location: index.php?url=VoteController/sudah');
                } else {
                    header('Location: index.php?url=KandidatController/index');
                }
            }
            exit;
        } else {
            echo "<script>alert('Email atau password salah!');window.location='index.php?url=LoginController/index';</script>";
        }
    }

    public function register()
    {
        $this->view('auth/register');
    }

    public function prosesRegister()
    {
        require_once __DIR__ . '/../../config/koneksi.php';

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = 'user'; // default untuk user baru

        $stmt = $koneksi->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $role);

        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil! Silakan login.');window.location='index.php?url=LoginController/index';</script>";
        } else {
            echo "<script>alert('Registrasi gagal!');window.location='index.php?url=LoginController/register';</script>";
        }
    }

    public function logout()
    {
        session_start();

        // Opsional: Anda juga bisa mencatat log Logout jika mau
        if (isset($_SESSION['user'])) {
            // require_once ... (pastikan model Log bisa dipanggil jika ingin log logout)
        }

        $_SESSION = [];       // bersihkan semua session
        session_unset();      // hapus variabel session
        session_destroy();    // hancurkan session di server
        header('Location: index.php?url=LoginController/index');
        exit;
    }
}
?>