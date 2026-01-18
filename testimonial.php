<?php
include 'db.php';

$result = mysqli_query($koneksi, "SELECT * FROM testimonial ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Testimoni Pelanggan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Testimoni Pelanggan</h2>

<?php if (isset($_GET['success'])) { ?>
    <p style="color:green;">Testimoni berhasil dikirim!</p>
<?php } ?>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong><?php echo $row['nama']; ?></strong><br>
        <p><?php echo $row['komentar']; ?></p>

        <?php if (!empty($row['foto'])) { ?>
            <img src="uploads/<?php echo $row['foto']; ?>" width="120">
        <?php } ?>
    </div>
<?php } ?>

</body>
</html>
