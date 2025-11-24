<?php
class User
{
    private $conn;

    public function __construct()
    {
        // Pastikan file koneksi ditemukan
        $path = realpath(__DIR__ . '/../../config/koneksi.php');
        if (!file_exists($path)) {
            die("❌ File koneksi.php tidak ditemukan di: " . $path);
        }

        // Load koneksi.php
        require_once $path;

        // Ambil koneksi global
        global $koneksi;
        if ($koneksi instanceof mysqli) {
            $this->conn = $koneksi;
        } else {
            // fallback – buat koneksi manual jika gagal
            $this->conn = new mysqli("localhost", "root", "", "db_voting");
            if ($this->conn->connect_errno) {
                die("❌ Gagal membuat koneksi manual: " . $this->conn->connect_error);
            }
        }
    }

    // === REGISTER ===
    public function register($username, $email, $password, $role = 'user')
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);
        return $stmt->execute();
    }

    // === LOGIN ===
    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$stmt) {
            die("❌ Query prepare gagal: " . $this->conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            } else {
                // Debug: tampilkan kalau password salah
                error_log("❌ Password salah untuk email: $email");
            }
        } else {
            // Debug: tampilkan kalau email tidak ditemukan
            error_log("❌ Email tidak ditemukan: $email");
        }

        return false;
    }

    // === CEK EMAIL ===
    public function cekEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
