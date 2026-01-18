<?php
session_start();
if(!isset($_SESSION['admin_login'])){
    header("Location: login.php");
    exit;
}

include "db.php";
$ambil = mysqli_query($koneksi, "SELECT * FROM service ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
  <span class="navbar-brand">Admin Panel</span>
  <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</nav>

<div class="container my-4">
    <h3>Data Service Masuk</h3>

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Jenis</th>
                <th>Status</th>
                <th>Alamat</th>
                <th>Ubah</th>
            </tr>
        </thead>
        <tbody>
        <?php while($d = mysqli_fetch_assoc($ambil)){ ?>
            <tr>
                <td><?= $d['kode']; ?></td>
                <td><?= $d['nama']; ?></td>
                <td><?= $d['telepon']; ?></td>
                <td><?= $d['jenis']; ?></td>
                <td><?= $d['status']; ?></td>
                <td><?= $d['alamat']; ?></td>
                <td>
                    <a class="btn btn-sm btn-primary mb-1" 
                       href="update_status.php?id=<?= $d['id']; ?>">
                       Update
                    </a>

                    <button 
                        class="btn btn-sm btn-danger mb-1"
                        onclick="hapusData(<?= $d['id']; ?>)">
                        Hapus
                    </button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
function hapusData(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data service akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'hapus_service.php?id=' + id;
        }
    });
}
</script>

</body>
</html>
