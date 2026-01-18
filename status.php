<?php
include 'db.php';

// Cegah error jika dibuka langsung
$kode = $_GET['kode'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h3 class="text-center mb-4">Status Service</h3>

<?php
if ($kode == '') {
    echo '<div class="alert alert-info text-center">
            Silakan masukkan kode service melalui halaman utama.
          </div>';
} else {

    $kode = mysqli_real_escape_string($koneksi, $kode);
    $query = mysqli_query($koneksi, "SELECT * FROM service WHERE kode='$kode'");

    if (mysqli_num_rows($query) == 0) {
        echo '<div class="alert alert-danger text-center">
                Kode service tidak ditemukan!
              </div>';
    } else {
        $d = mysqli_fetch_assoc($query);
?>
    <div class="card shadow">
        <div class="card-body">
            <p><b>Kode Service:</b> <?= $d['kode']; ?></p>
            <p><b>Nama Pelanggan:</b> <?= $d['nama']; ?></p>
            <p><b>Barang:</b> <?= $d['jenis']; ?></p>
            
            <p><b>Status:</b>
<?php
$status = strtolower($d['status']);

switch ($status) {
    case 'menunggu':
        $label = 'Menunggu Konfirmasi Admin';
        $badge = 'secondary';
        $icon  = 'fa-clock';
        break;

    case 'proses':
        $label = 'Proses Service';
        $badge = 'warning';
        $icon  = 'fa-spinner';
        break;

    case 'perbaikan':
        $label = 'Sedang Dalam Perbaikan';
        $badge = 'primary';
        $icon  = 'fa-tools';
        break;

    case 'quality check':
        $label = 'Quality Check';
        $badge = 'info';
        $icon  = 'fa-search';
        break;

    case 'teknisi menuju ke lokasi':
        $label = 'Teknisi Menuju ke Lokasi';
        $badge = 'info';
        $icon  = 'fa-truck';
        break;

    case 'diambil':
        $label = 'Barang Diambil Teknisi';
        $badge = 'dark';
        $icon  = 'fa-box';
        break;

    case 'selesai':
        $label = 'Service Selesai';
        $badge = 'success';
        $icon  = 'fa-check-circle';
        break;

    default:
        $label = ucfirst($d['status']);
        $badge = 'secondary';
        $icon  = 'fa-info-circle';
}
?>
    <span class="badge bg-<?= $badge; ?> px-3 py-2">
        <i class="fas <?= $icon; ?> me-1"></i>
        <?= $label; ?>
    </span>
</p>

        </div>
    </div>
<?php
    }
}
?>

</div>
</body>
</html>
