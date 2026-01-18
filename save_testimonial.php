<?php
include 'db.php';

$nama = $_POST['nama'];
$komentar = $_POST['komentar'];
$foto = "";

if (!empty($_FILES['foto']['name'])) {
    $namaFile = time() . "_" . $_FILES['foto']['name'];
    $target = "uploads/" . $namaFile;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
        $foto = $namaFile;
    }
}

$query = "INSERT INTO testimonial (nama, komentar, foto) VALUES ('$nama', '$komentar', '$foto')";
mysqli_query($koneksi, $query);

header("Location: testimonial.php?success=1");
exit;
?>
