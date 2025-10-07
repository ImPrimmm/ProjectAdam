<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_realisasi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]));
}

$sql = "SELECT partai, pendidikan_politik, kesektariatan FROM realisasi";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "party" => $row["partai"],
            "chartData" => [
                ["category" => "Pendidikan Politik", "value" => (float)$row["pendidikan_politik"], "color" => 0x00ccff],
                ["category" => "Kesektariatan", "value" => (float)$row["kesektariatan"], "color" => 0x28a745]
            ]
        ];
    }
}

echo json_encode($data);
$conn->close();
