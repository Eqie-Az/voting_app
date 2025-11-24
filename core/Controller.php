<?php
class Controller
{
    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model;
    }

    public function view($view, $data = [])
    {
        // ----------------------------------------------------
        // REVISI: Mengubah array $data menjadi variabel individual
        // Contoh: ['logs' => $logData] menjadi $logs yang bisa diakses di view
        if (!empty($data)) {
            extract($data);
        }
        // ----------------------------------------------------
        
        require_once '../app/views/' . $view . '.php';
    }
}
?>