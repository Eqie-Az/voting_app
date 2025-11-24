<?php
// config/koneksi.php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_voting";

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("❌ Gagal terhubung ke database: " . $koneksi->connect_error);
}
?>