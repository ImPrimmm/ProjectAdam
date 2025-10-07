<?php
include "../include/database.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url("https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/231/2024/07/16/Gedung-Sate-Bandung-Abah-Shutterstock-2609867939.png") no-repeat center center;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(0, 0, 0, 0.7);
        }

        .card {
            width: 80%;
            height: 80%;
            background-color: rgb(0, 0, 0, 0.8);
            border-radius: 20px;
            color: white;
            display: flex;
            flex-direction: column;
            gap: 60px;
            justify-content: center;
            align-items: center;
        }

        .container .card div {
            background-color: white;
            width: 80%;
            height: 50px;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

            padding: 10px 14px;
            font-size: 16px;
            border: 2px solid #4a90e2;
            border-radius: 8px;
            background-color: #f9f9f9;
            color: #333;
            width: 100%;

            cursor: pointer;
            outline: none;
            transition: all 0.2s ease;

            background-image: url("data:image/svg+xml;utf8,<svg fill='black' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 40px;
        }

        select:hover {
            border-color: #357abd;
            background-color: #f1f7ff;
        }

        select:focus {
            border-color: #2c5aa0;
            box-shadow: 0 0 6px rgba(74, 144, 226, 0.5);
        }

        select {
            background-image: url("data:image/svg+xml;utf8,<svg fill='black' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .idWrapper {
            display: flex;
            flex-direction: column;

        }
    </style>
</head>

<body>
    <div class="container">
        <form class="card" method="post" action="query_update.php">
            <div id="idWrapper">
                <select id="mySelect">
                    <option value="GERINDRA">GERINDRA</option>
                    <option value="PKS">PKS</option>
                    <option value="GOLKAR">GOLKAR</option>
                    <option value="PDIP">PDIP</option>
                    <option value="PKB">PKB</option>
                    <option value="DEMOKRAT">DEMOKRAT</option>
                    <option value="PAN">PAN</option>
                    <option value="NASDEM">NASDEM</option>
                    <option value="PPP">PPP</option>
                    <option value="PSI">PSI</option>
                </select>
            </div>
            <div id="pendidikanPolitikWrapper">
                <label for="pendidikanPolitik">Pendidikan Politik</label>
                <input type="number" name="" id="">
            </div>
            <div id="kesektariatanWrapper"></div>
            <div id="buttonWrapper"></div>
        </form>
    </div>

    <script>
        const id = document.getElementById('mySelect');
        id.addEventListener('change', function () {

        });
        async function loadData() {
            try {
                const response = await fetch("../Dashboard/getData.php");
                const data = await response.json();
            } catch (error) {
                console.error("Gagal ambil data:", error);
            }
        }
    </script>
</body>

</html>