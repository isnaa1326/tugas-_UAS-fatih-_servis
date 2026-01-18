<?php
session_start();
if(!isset($_SESSION['admin_login'])){
    header("Location: login.php");
    exit;
}

include "db.php";

if(!isset($_GET['id'])){
    header("Location: admin.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM service WHERE id='$id'");

header("Location: admin.php");
exit;
