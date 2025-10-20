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

<body class="bg-gray-100 font-sans bg-cover bg-no-repeat" style="background-image: url('../assets/adam-bg.jpeg');">

    <!-- Navbar -->
    <header class="bg-gray-200 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-8 flex justify-between items-center">
            <!-- Left: Menu -->
            <div class="flex items-center space-x-4">
                <h1 class="text-xl font-bold text-black tracking-wide">Admin Panel</h1>
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

    <div class="max-w-3xl mx-auto mt-32 bg-white p-10 rounded-xl shadow-2xl border border-gray-100">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-8 border-b pb-3">Tambah Data Realisasi</h2>

        <?php if (!empty($message)): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="import_process.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="flex flex-col space-y-2">
                <label class="block text-sm font-medium text-gray-700">Pilih File (.CSV):</label>

                <div id="file-input-container">
                    <label for="file-upload" id="upload-label"
                        class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-900 bg-gray-50 hover:bg-gray-100 cursor-pointer transition duration-150 ease-in-out">
                        Pilih File CSV
                    </label>
                </div>

                <input id="file-upload" name="file" type="file" accept=".csv" class="sr-only">

                <div id="file-preview"
                    class="hidden w-full p-3 border border-indigo-200 bg-indigo-50 rounded-lg flex justify-between items-center transition duration-300">
                    <span id="file-name" class="text-sm font-medium text-indigo-700 truncate"></span>
                    <button type="button" id="cancel-file-btn"
                        class="ml-4 p-1 rounded-full text-gray-900 hover:bg-gray-600 hover:text-gray-700 transition duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Hanya file dengan format **.csv** yang diperbolehkan.</p>
            </div>

            <div>
                <button type="submit" id="submit-btn"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 014 9H7z"></path>
                    </svg>
                    Import Data
                </button>
            </div>

            <button type="button"
                class="flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg shadow-sm transition">
                <!-- Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <a href="dashboard.php">Cancel</a>
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('file-upload');
            const filePreview = document.getElementById('file-preview');
            const fileNameSpan = document.getElementById('file-name');
            const cancelBtn = document.getElementById('cancel-file-btn');
            const uploadLabel = document.getElementById('upload-label');
            const submitBtn = document.getElementById('submit-btn');

            // Fungsi yang dipanggil saat file dipilih
            fileInput.addEventListener('change', function () {
                if (this.files.length > 0) {
                    // Tampilkan pratinjau
                    fileNameSpan.textContent = this.files[0].name;
                    filePreview.classList.remove('hidden');

                    // Sembunyikan tombol pilih file asli
                    uploadLabel.classList.add('hidden');

                    // Aktifkan tombol submit
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    // Sembunyikan pratinjau jika file dibatalkan (misalnya lewat dialog OS)
                    filePreview.classList.add('hidden');
                    uploadLabel.classList.remove('hidden');

                    // Non-aktifkan tombol submit jika tidak ada file
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });

            // Fungsi yang dipanggil saat tombol batal (Cancel) diklik
            cancelBtn.addEventListener('click', function () {
                // 1. Reset nilai input file (penting!)
                fileInput.value = '';

                // 2. Sembunyikan pratinjau
                filePreview.classList.add('hidden');

                // 3. Tampilkan kembali tombol pilih file
                uploadLabel.classList.remove('hidden');

                // 4. Non-aktifkan tombol submit
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            });

            // Inisialisasi: Non-aktifkan tombol submit saat pertama kali loading jika tidak ada file
            if (fileInput.files.length === 0) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
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