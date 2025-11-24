<?php
// Pastikan koneksi diload dari path yang benar
require_once __DIR__ . '/../../config/koneksi.php';

class Kandidat
{
    private $conn;

    public function __construct()
    {
        $path = realpath(__DIR__ . '/../../config/koneksi.php');
        if (!file_exists($path)) {
            die('❌ File koneksi.php tidak ditemukan di: ' . $path);
        }

        require_once $path;

        global $koneksi;
        if (isset($koneksi) && $koneksi instanceof mysqli) {
            $this->conn = $koneksi;
        } else {
            $this->conn = new mysqli("localhost", "root", "", "db_voting");
            if ($this->conn->connect_error) {
                die('❌ Gagal koneksi database: ' . $this->conn->connect_error);
            }
        }
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM kandidat");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function add($nama_ketua, $nama_wakil, $foto)
    {
        $stmt = $this->conn->prepare("INSERT INTO kandidat (nama_ketua, nama_wakil, foto) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama_ketua, $nama_wakil, $foto);
        $stmt->execute();
    }

    public function delete($id)
    {
        // 1️⃣ Hapus dulu semua voting yang memilih kandidat ini (Logika database relasional)
        $stmtVoting = $this->conn->prepare("DELETE FROM voting WHERE kandidat_id = ?");
        $stmtVoting->bind_param("i", $id);
        $stmtVoting->execute();
        $stmtVoting->close();

        // 2️⃣ Baru hapus kandidatnya
        $stmtKandidat = $this->conn->prepare("DELETE FROM kandidat WHERE id = ?");
        $stmtKandidat->bind_param("i", $id);
        $result = $stmtKandidat->execute();
        $stmtKandidat->close();

        return $result;
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM kandidat WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($id, $nama_ketua, $nama_wakil, $foto = null)
    {
        if ($foto) {
            $stmt = $this->conn->prepare("UPDATE kandidat SET nama_ketua=?, nama_wakil=?, foto=? WHERE id=?");
            $stmt->bind_param("sssi", $nama_ketua, $nama_wakil, $foto, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE kandidat SET nama_ketua=?, nama_wakil=? WHERE id=?");
            $stmt->bind_param("ssi", $nama_ketua, $nama_wakil, $id);
        }
        $stmt->execute();
    }

    public function getAllKandidat()
    {
        $query = "SELECT * FROM kandidat ORDER BY id DESC";
        $result = $this->conn->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}