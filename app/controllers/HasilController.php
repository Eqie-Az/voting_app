<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class HasilController extends Controller
{
    public function index()
    {
        // Pastikan hanya admin yang bisa lihat hasil
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?url=LoginController/index');
            exit;
        }

        // Ambil semua kandidat dan total suara dari model
        $kandidatModel = $this->model('Kandidat');
        $voteModel = $this->model('Vote');

        $kandidatList = $kandidatModel->getAll();
        $totalSuara = $voteModel->getTotalSuara(); // fungsi di model Vote untuk hitung total semua suara

        // Hitung persentase per kandidat
        foreach ($kandidatList as &$k) {
            $jumlahSuara = $voteModel->getJumlahSuaraByKandidat($k['id']);
            $k['jumlah_suara'] = $jumlahSuara;
            $k['persentase'] = $totalSuara > 0 ? round(($jumlahSuara / $totalSuara) * 100, 2) : 0;
        }

        $this->view('hasil/index', ['kandidat' => $kandidatList, 'totalSuara' => $totalSuara]);
    }
}
?>