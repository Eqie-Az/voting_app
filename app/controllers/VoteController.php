<?php
class VoteController extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=LoginController/index');
            exit;
        }

        $user_id = $_SESSION['user']['id'];
        $voteModel = $this->model('Vote');

        // Jika sudah vote DAN sudah verified, langsung ke halaman terima kasih
        if ($voteModel->isVerified($user_id)) {
            header('Location: index.php?url=VoteController/sudah');
            exit;
        }

        // Jika sudah vote tapi MASIH PENDING, lempar ke halaman verifikasi
        if ($voteModel->sudahVote($user_id)) {
            header('Location: index.php?url=VoteController/halamanVerifikasi');
            exit;
        }

        $kandidatModel = $this->model('Kandidat');
        $kandidat = $kandidatModel->getAllKandidat();
        $this->view('vote/index', ['kandidat' => $kandidat]);
    }

    public function vote($id)
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=LoginController/index');
            exit;
        }

        $user_id = $_SESSION['user']['id'];
        $voteModel = $this->model('Vote');

        if ($voteModel->sudahVote($user_id)) {
            // Jika sudah vote (entah pending/verified), cek statusnya
            if (!$voteModel->isVerified($user_id)) {
                header('Location: index.php?url=VoteController/halamanVerifikasi');
            } else {
                header('Location: index.php?url=VoteController/sudah');
            }
            exit;
        }

        // Simpan sebagai PENDING
        $voteModel->simpanVote($user_id, $id);

        // Arahkan ke halaman verifikasi (bukan halaman sudah)
        header('Location: index.php?url=VoteController/halamanVerifikasi');
        exit;
    }

    // Halaman untuk menampilkan tombol verifikasi
    public function halamanVerifikasi()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=LoginController/index');
            exit;
        }
        $this->view('vote/verifikasi'); // Kita akan buat file view ini
    }

    // Proses saat tombol "Sahkan" diklik
    public function prosesVerifikasi()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=LoginController/index');
            exit;
        }

        $user_id = $_SESSION['user']['id'];
        $voteModel = $this->model('Vote');

        // Ubah status jadi VERIFIED
        $voteModel->verifikasiVote($user_id);

        // Catat Log bahwa user sudah memverifikasi suaranya
        $logModel = $this->model('Log');
        $logModel->logAction($user_id, 'Verifikasi Suara', $_SERVER['REMOTE_ADDR']);

        // Arahkan ke halaman final
        header('Location: index.php?url=VoteController/sudah');
        exit;
    }

    public function sudah()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=LoginController/index');
            exit;
        }
        $this->view('vote/sudah');
    }
}