<?php
include "../include/database.php";
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $partai = mysqli_real_escape_string($conn, $_POST['partai']);
    $pendidikan = mysqli_real_escape_string($conn, $_POST['pendidikan_politik']);
    $kesektariatan = mysqli_real_escape_string($conn, $_POST['kesektariatan']);

    $sql = "INSERT INTO realisasi (partai, pendidikan_politik, kesektariatan) 
            VALUES ('$partai', '$pendidikan', '$kesektariatan')";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php?success=1");
        exit();
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <header class="bg-gray-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-8 flex justify-between items-center">
            <!-- Left: Menu -->
            <div class="flex items-center space-x-4">
                <button onclick="openNav()" class="text-gray-300 hover:text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-xl font-bold tracking-wide">Dashboard</h1>
            </div>

            <!-- Right: Search + Profile -->
            <div class="flex items-center space-x-6">
                <!-- Search -->
                <div class="relative">
                    <input type="text" placeholder="Search..."
                        class="pl-10 pr-4 py-2 rounded-full bg-gray-800 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-white placeholder-gray-400">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                </div>

                <!-- Profile -->
                <button onclick="openDrawer()" class="focus:outline-none">
                    <img src="../assets/profile.jpg" alt="profile"
                        class="rounded-full w-10 h-10 border-2 border-gray-700 hover:border-blue-500 transition duration-300">
                </button>
            </div>
        </div>
    </header>

    <!-- Drawer -->
    <div id="profileDrawer"
        class="fixed top-0 right-0 w-64 h-full bg-gray-900 text-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-50 flex flex-col">

        <!-- Header -->
        <div class="p-4 flex justify-between items-center border-b border-gray-700">
            <h2 class="text-lg font-bold">Account</h2>
            <button onclick="closeDrawer()" class="text-2xl">&times;</button>
        </div>

        <!-- Content (scrollable) -->
        <div class="p-4 space-y-4 flex-1 overflow-y-auto">
            <div class="flex items-center space-x-3">
                <img src="../assets/profile.jpg" class="rounded-full w-12 h-12">
                <div>
                    <p class="font-semibold">
                        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
                    </p>
                    <p class="text-sm text-gray-400">
                        <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'example@email.com'; ?>
                    </p>
                </div>
            </div>
            <hr class="border-gray-700">
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">About</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Services</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Clients</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Contact</a>
        </div>

        <!-- Logout di paling bawah -->
        <div class="p-4 border-t border-gray-700">
            <a href="logout.php"
                class="block w-full text-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">
                Logout
            </a>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="mySidenav"
        class="fixed left-0 top-0 h-full w-0 bg-gray-900 text-white overflow-x-hidden transition-all duration-300 z-50 flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
            <img src="../assets/logo kesbangpol BARU.png" class="w-[200px]">
            <button onclick="closeNav()"
                class="text-gray-400 hover:text-white text-2xl focus:outline-none transition-colors duration-200">
                &times;
            </button>
        </div>

        <!-- Menu -->
        <div class="flex-1 p-4 space-y-2">
            <a href="#" class="block py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors duration-200">About</a>
            <a href="#" class="block py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors duration-200">Services</a>
            <a href="#" class="block py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors duration-200">Clients</a>
            <a href="#" class="block py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors duration-200">Contact</a>
        </div>
    </div>

    <div class="max-w-3xl mx-auto mt-12 bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6">Tambah Data Realisasi</h2>

        <?php if (!empty($message)): ?>
            <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <!-- Partai -->
            <div>
                <label class="block mb-2 font-semibold">Partai</label>
                <input type="text" name="partai" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Pendidikan Politik -->
            <div>
                <label class="block mb-2 font-semibold">Pendidikan Politik</label>
                <textarea name="pendidikan_politik" required rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- Kesektariatan -->
            <div>
                <label class="block mb-2 font-semibold">Kesektariatan</label>
                <textarea name="kesektariatan" required rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between">
                <a href="dashboard.php" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>

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