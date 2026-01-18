<?php
// ====== KONEKSI DATABASE ======
$host = "localhost";
$user = "root";
$pass = "";
$db   = "fatih_servis";

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Auto-detect domain / hosting
$base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/";

// Fungsi aman input
function aman($value){
    global $koneksi;
    return mysqli_real_escape_string($koneksi, htmlspecialchars($value));
}
?>
