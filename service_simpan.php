<?php
include "db.php";

// generate kode
$kode = "FES-" . rand(10000,99999);

$nama = aman($_POST['nama']);
$telp = aman($_POST['telepon']);
$alamat = aman($_POST['alamat']);
$jenis = aman($_POST['jenis']);
$keluhan = aman($_POST['keluhan']);

mysqli_query($koneksi, "INSERT INTO service (kode,nama,telepon,alamat,jenis,keluhan,status) 
VALUES ('$kode','$nama','$telp','$alamat','$jenis','$keluhan','Menunggu')");

// redirect + WA admin
$wa_admin = "625876865046";

$pesan = urlencode("Halo Admin, ada service baru:\nKode: $kode\nNama: $nama\nJenis: $jenis\nKeluhan: $keluhan\nalamat: $alamat");
header("Location: https://wa.me/$wa_admin?text=$pesan");
exit;
?>
