<?php
// ✅ Aktifkan error reporting supaya semua error muncul
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Panggil core utama
require_once '../core/App.php';
require_once '../core/Controller.php';
require_once '../config/config.php';
require_once '../core/App.php';


// Jalankan aplikasi
$app = new App();
?>