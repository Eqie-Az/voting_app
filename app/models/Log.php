<?php

require_once __DIR__ . '/../../config/koneksi.php';

class Log
{
    private $conn;

    public function __construct()
    {
        global $koneksi;

        // Logika koneksi robust
        if (!$koneksi instanceof mysqli || $koneksi->connect_error) {
            $this->conn = new mysqli("localhost", "root", "", "db_voting");
            if ($this->conn->connect_error) {
                die("Koneksi database GAGAL TOTAL: " . $this->conn->connect_error);
            }
        } else {
            $this->conn = $koneksi;
        }
    }

    // Fungsi untuk mencatat log
    public function logAction($user_id, $action, $ip_address)
    {
        $stmt = $this->conn->prepare("INSERT INTO logs (user_id, action, ip_address) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $action, $ip_address);
        return $stmt->execute();
    }

    // Fungsi mengambil data log + Email & Username
    public function getAllLogs()
    {
        // JOIN ke tabel users untuk ambil username dan email
        $query = "
            SELECT 
                l.id, 
                l.user_id, 
                u.username, 
                u.email, 
                l.action, 
                l.timestamp, 
                l.ip_address 
            FROM logs l
            LEFT JOIN users u ON l.user_id = u.id 
            ORDER BY l.timestamp DESC
        ";

        $result = $this->conn->query($query);

        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }
}