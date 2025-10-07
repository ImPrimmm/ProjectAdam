<?php
include "../include/database.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT id, partai, pendidikan_politik, kesektariatan FROM realisasi";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./styles/dashboard.css">
</head>

<body>

    <div class="container">
        <div class="wrapper">
            <header>
                <nav>
                    <div id="main">
                        <span style="font-size:30px;cursor:pointer;color:white;" onclick="openNav()">&#9776;</span>
                    </div>
                    <div class="profileSection">
                        <img src="../assets/profile.jpg" class="profile" alt="profile" height="50">
                        <a href="logout.php" class="textLogout">
                            <p>Logout</p>
                        </a>
                        <a href="logout.php" class="linkLogout"><img src="../assets/logout-512.png" class="logout" alt="logout" height="20"></a>
                    </div>
                </nav>
            </header>

            <div id="mySidenav" class="sidenav">
                <img src="../assets/logo kesbangpol BARU.png" alt="logo kesbangpol" height="40" class="logoKes">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a><br>
                <a href="#">About</a>
                <a href="#">Services</a>
                <a href="#">Clients</a>
                <a href="#">Contact</a>
            </div>

            <main>
                <table class="darkTable" id="table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Partai</th>
                            <th>Pendidikan Politik</th>
                            <th>Kesektariatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // 3. Loop hasil query
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['partai'] . "</td>";
                                echo "<td>" . $row['pendidikan_politik'] . "</td>";
                                echo "<td>" . $row['kesektariatan'] . "</td>";
                                echo "<td>" . "<a href='edit.php'><img src='../assets/edit (1).png' height='20' style='cursor:pointer;'></a>" . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>



    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "400px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>
</body>

</html>