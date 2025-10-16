<?php
include "../include/database.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("127.0.0.1", "root", "", "db_realisasi");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// pastikan ada id
if (!isset($_GET['id'])) {
    header("Location: dashboard.php?status=error");
    exit();
}

$id = intval($_GET['id']);

$sql = "DELETE FROM realisasi WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php?status=deleted");
    exit();
} else {
    echo "Error menghapus data: " . $conn->error;
}
