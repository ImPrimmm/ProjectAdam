<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../include/database.php";
mysqli_set_charset($conn, "utf8mb4");

if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['error'] == 0) {
    $file = $_FILES['file']['tmp_name'];

    if (($handle = fopen($file, "r")) !== FALSE) {
        fgetcsv($handle); // skip header

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($data) < 3)
                continue;

            // pastikan encoding UTF-8
            $partai = mb_convert_encoding(trim($data[0]), 'UTF-8', 'auto');
            $pendidikan_politik = mb_convert_encoding(trim($data[1]), 'UTF-8', 'auto');
            $kesektariatan = mb_convert_encoding(trim($data[2]), 'UTF-8', 'auto');

            $sql = "INSERT INTO realisasi (partai, pendidikan_politik, kesektariatan) 
                    VALUES ('$partai', '$pendidikan_politik', '$kesektariatan')";

            if (!mysqli_query($conn, $sql)) {
                echo "❌ MySQL Error: " . mysqli_error($conn) . "<br>";
            }
        }
        fclose($handle);
        
        header("Location: index.php?status=success");
        echo "✅ Data berhasil diimport!";
    } else {
        echo "❌ Gagal membaca file.";
    }
} else {
    echo "❌ Tidak ada file yang diupload atau ada error.";
}
