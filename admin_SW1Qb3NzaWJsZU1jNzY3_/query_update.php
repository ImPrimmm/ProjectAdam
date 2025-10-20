<?php
include "../include/database.php";

$conn = new mysqli("127.0.0.1", "root", "", "db_realisasi");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = intval($_POST['id']);
$partai = $_POST['partai'];
$pendidikan = $_POST['pendidikan_politik'];
$kesektariatan = $_POST['kesektariatan'];

$sql = "UPDATE realisasi 
        SET partai='$partai', pendidikan_politik='$pendidikan', kesektariatan='$kesektariatan' 
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php?status=updated");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
