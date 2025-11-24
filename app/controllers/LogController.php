<?php
// -------------------------------------------------------------------------
// REVISI KRUSIAL: Memastikan session dimulai di controller ini 
// agar $_SESSION['user'] tersedia sebelum pengecekan otorisasi.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// -------------------------------------------------------------------------

// Pastikan class Controller (base class) sudah dimuat oleh App.php
class LogController extends Controller
{
    public function index()
    {
        // 1. Otorisasi: Hanya Admin yang bisa melihat log
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // Arahkan ke halaman login jika tidak diizinkan
            header('Location: index.php?url=LoginController/index');
            exit;
        }

        // 2. Pemanggilan Model
        $model = $this->model('Log');
        $logs = $model->getAllLogs();

        // 3. Tampilkan View, kirim data log
        $this->view('logs/index', ['logs' => $logs]);
    }
    
    // Anda bisa menambahkan method lain seperti:
    // public function clearLogs() { ... }
}