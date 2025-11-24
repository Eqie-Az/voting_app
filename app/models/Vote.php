<?php
require_once __DIR__ . '/../../config/koneksi.php';

class Vote
{
    private $conn;

    public function __construct()
    {
        global $koneksi;
        if (!$koneksi instanceof mysqli) {
            $this->conn = new mysqli("localhost", "root", "", "db_voting");
        } else {
            $this->conn = $koneksi;
        }
    }

    public function sudahVote($user_id)
    {
        // Cek voting, tapi kita abaikan dulu statusnya
        // Agar sistem tahu user ini sudah ada record-nya
        $stmt = $this->conn->prepare("SELECT * FROM voting WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // 🔹 Cek apakah status user sudah VERIFIED
    public function isVerified($user_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM voting WHERE user_id = ? AND status = 'verified'");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function simpanVote($user_id, $kandidat_id)
    {
        if ($this->sudahVote($user_id)) {
            return false;
        }

        // 🔴 PERUBAHAN 1: Simpan sebagai PENDING dulu!
        $default_status = 'pending';

        $stmt = $this->conn->prepare("INSERT INTO voting (user_id, kandidat_id, timestamp, status) VALUES (?, ?, NOW(), ?)");
        $stmt->bind_param("iis", $user_id, $kandidat_id, $default_status);
        $result = $stmt->execute();

        // Kita HAPUS update user 'sudah_voting' disini.
        // User baru dianggap 'sudah_voting' sepenuhnya setelah verifikasi.

        return $result;
    }

    // 🟢 FUNGSI BARU: User melakukan verifikasi sendiri
    public function verifikasiVote($user_id)
    {
        // Ubah status pending menjadi verified
        $stmt = $this->conn->prepare("UPDATE voting SET status = 'verified' WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $result = $stmt->execute();

        if ($result) {
            // Baru sekarang kita tandai user ini benar-benar selesai
            $updateUserStmt = $this->conn->prepare("UPDATE users SET sudah_voting = 1 WHERE id = ?");
            $updateUserStmt->bind_param("i", $user_id);
            $updateUserStmt->execute();
        }
        return $result;
    }

    public function getHasilVoting()
    {
        // Hanya hitung yang verified
        $query = "
            SELECT k.id, k.nama_ketua, k.nama_wakil, k.foto, 
            COUNT(CASE WHEN v.status = 'verified' THEN 1 END) AS jumlah_suara
            FROM kandidat k
            LEFT JOIN voting v ON k.id = v.kandidat_id
            GROUP BY k.id
            ORDER BY jumlah_suara DESC
        ";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalSuara()
    {
        $query = "SELECT COUNT(*) AS total FROM voting WHERE status = 'verified'";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row ? (int) $row['total'] : 0;
    }

    public function getJumlahSuaraByKandidat($id_kandidat)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM voting WHERE kandidat_id = ? AND status = 'verified'");
        $stmt->bind_param("i", $id_kandidat);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? (int) $row['total'] : 0;
    }
}
?>