<?php
if (!defined('BASEURL')) {
    // Deteksi protokol (http atau https)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

    // Ambil domain, misalnya: voting.wuaze.com
    $host = $_SERVER['HTTP_HOST'];

    // Ambil path relatif ke root web (misalnya /voting_app/public/)
    $basePath = rtrim(str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), '/');

    // Bentuk URL dasar yang valid untuk browser
    define('BASEURL', $protocol . $host . $basePath . '/');
}
