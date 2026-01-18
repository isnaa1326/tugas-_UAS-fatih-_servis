<?php
session_start();
include "db.php";

// Proteksi Admin
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM service WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) { die("Data tidak ditemukan!"); }

// Proses Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = aman($_POST['status']);
    mysqli_query($koneksi, "UPDATE service SET status='$status' WHERE id='$id'");
    header("Location: admin.php?pesan=updated");
    exit;
}

// Menyiapkan Pesan WhatsApp Otomatis
$nomor_wa = $data['telepon'];
// Membersihkan nomor telepon jika ada karakter non-digit
$nomor_wa = preg_replace('/[^0-9]/', '', $nomor_wa);
// Pastikan format nomor diawali 62 (Indonesia)
if (substr($nomor_wa, 0, 1) === '0') {
    $nomor_wa = '62' . substr($nomor_wa, 1);
}

$pesan_wa = urlencode("Halo Kak " . $data['nama'] . ",\n\nKami dari Fatih Ekosistem ingin menginformasikan bahwa pengerjaan " . $data['jenis'] . " dengan kode *" . $data['kode'] . "* saat ini statusnya adalah: *" . $data['status'] . "*.\n\nSilakan cek detailnya di web kami. Terima kasih!");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Status Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card { border-radius: 15px; }
        .btn-wa { background-color: #25D366; color: white; }
        .btn-wa:hover { background-color: #128C7E; color: white; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-center">Update Status: <b><?= $data['kode']; ?></b></h4>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Ubah Status</label>
                            <select name="status" class="form-select">
                                <?php 
                                $options = ["Menunggu", "Proses", "Perbaikan", "Quality Check", "Selesai", "Diambil"];
                                foreach ($options as $opt) {
                                    $selected = ($data['status'] == $opt) ? "selected" : "";
                                    echo "<option value='$opt' $selected>$opt</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary py-2">Simpan Perubahan</button>
                            <hr>
                            <a href="https://wa.me/<?= $nomor_wa; ?>?text=<?= $pesan_wa; ?>" target="_blank" class="btn btn-wa py-2">
                                💬 Kabari Pelanggan via WA
                            </a>
                            <a href="admin.php" class="btn btn-light">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>