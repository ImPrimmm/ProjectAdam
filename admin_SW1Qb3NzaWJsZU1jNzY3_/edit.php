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

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = intval($_GET['id']);

// Ambil data sesuai ID
$sql = "SELECT * FROM realisasi WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Data tidak ditemukan.");
}

$data = $result->fetch_assoc();

// Ambil semua partai (untuk select option)
$sql_partai = "SELECT id, partai FROM realisasi";
$partai_result = $conn->query($sql_partai);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex items-center justify-center bg-gray-900 bg-opacity-70"
    style="background: url('https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/231/2024/07/16/Gedung-Sate-Bandung-Abah-Shutterstock-2609867939.png') no-repeat center center; background-size: cover;">

    <div class="bg-black bg-opacity-80 backdrop-blur-md rounded-2xl shadow-xl w-full max-w-2xl p-10 text-white">
        <h1 class="text-2xl font-bold mb-8 text-center">Edit Data Realisasi</h1>

        <form method="POST" action="query_update.php" class="space-y-6">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">

            <!-- Select Partai -->
            <div>
                <label for="partai" class="block mb-2 text-sm font-medium">Pilih Partai</label>
                <select id="partai" name="partai" required
                    class="w-full p-3 rounded-lg border border-blue-500 bg-gray-100 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">Pilih Partai</option>
                    <?php while ($row = $partai_result->fetch_assoc()): ?>
                        <option value="<?= $row['partai'] ?>" <?= ($row['partai'] == $data['partai']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['partai']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Input Pendidikan Politik -->
            <div>
                <label for="pendidikan_politik" class="block mb-2 text-sm font-medium">Pendidikan Politik</label>
                <input type="number" id="pendidikan_politik" name="pendidikan_politik"
                    value="<?= $data['pendidikan_politik'] ?>"
                    class="w-full p-3 rounded-lg border border-blue-500 bg-gray-100 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    required>
            </div>

            <!-- Input Kesektariatan -->
            <div>
                <label for="kesektariatan" class="block mb-2 text-sm font-medium">Kesektariatan</label>
                <input type="number" id="kesektariatan" name="kesektariatan" value="<?= $data['kesektariatan'] ?>"
                    class="w-full p-3 rounded-lg border border-blue-500 bg-gray-100 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    required>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end space-x-4 pt-6">
                <a href="dashboard.php"
                    class="px-5 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 text-white font-medium transition">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition">Update</button>
            </div>
        </form>

        <script>
            const drawer = document.getElementById("profileDrawer");
            function openDrawer() {
                drawer.classList.remove("translate-x-full");
            }
            function closeDrawer() {
                drawer.classList.add("translate-x-full");
            }

            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
            }
            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }

            function toggleDropdown(id) {
                const dropdown = document.getElementById(id);

                document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                    if (el.id !== id) el.classList.add('hidden');
                });

                dropdown.classList.toggle('hidden');
            }

            window.addEventListener('click', function (e) {
                if (!e.target.closest('button') && !e.target.closest('[id^="dropdown-"]')) {
                    document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
                }
            });
        </script>

</body>

</html>