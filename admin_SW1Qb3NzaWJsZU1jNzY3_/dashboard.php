<?php
include "../include/database.php";
session_start();

if (isset($_SESSION['username']) && !isset($_SESSION['email'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT email FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email'];
    }
}

$limit = 10;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT id, partai, pendidikan_politik, kesektariatan FROM realisasi LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

$total_sql = "SELECT COUNT(*) as total FROM realisasi";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_data = $total_row['total'];

$total_pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CRUD</title>
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

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Data Realisasi</h2>
            <a href="create.php" class="flex px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Data
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-gray-800 text-white text-sm uppercase">
                    <tr>
                        <th class="text-center py-6">ID</th>
                        <th class="text-center py-6">Partai</th>
                        <th class="text-center py-6">Pendidikan Politik</th>
                        <th class="text-center py-6">Kesektariatan</th>
                        <th class="text-center py-6">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr class="border-b hover:bg-gray-200">
                                <td class="text-center py-6"><?php echo $row['id']; ?></td>
                                <td class="text-center py-6"><?php echo $row['partai']; ?></td>
                                <td class="text-center py-6"><?php echo $row['pendidikan_politik']; ?></td>
                                <td class="text-center py-6"><?php echo $row['kesektariatan']; ?></td>
                                <td class="text-center py-6 relative">
                                    <button type="button" onclick="toggleDropdown('dropdown-<?php echo $row['id']; ?>')"
                                        class="inline-flex justify-center items-center px-3 py-1 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none">
                                        ⋮
                                    </button>

                                    <div id="dropdown-<?php echo $row['id']; ?>"
                                        class="hidden absolute right-3 mt-2 w-32 bg-white rounded-lg shadow-lg border border-gray-200 z-10">

                                        <a href="edit.php?id=<?php echo $row['id']; ?>"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Edit
                                        </a>

                                        <button onclick="openDeleteModal(<?php echo $row['id']; ?>)"
                                            class="block px-11 py-2 text-sm text-red-600 hover:bg-red-50">
                                            Delete
                                        </button>

                                        <!-- Modal Delete -->
                                        <div id="deleteModal"
                                            class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                                            <div class="bg-gray-900 rounded-lg shadow-lg w-full max-w-md p-6">
                                                <h2 class="text-lg font-bold text-gray-100 mb-4">Konfirmasi Hapus</h2>
                                                <p class="text-gray-100 mb-6">Apakah kamu yakin ingin menghapus data ini?</p>

                                                <!-- Form delete -->
                                                <form id="deleteForm" method="GET" action="delete.php">
                                                    <input type="hidden" name="id" id="deleteId">
                                                    <div class="flex justify-end space-x-3">
                                                        <button type="button" onclick="closeDeleteModal()"
                                                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="flex justify-center items-center space-x-2 py-6">
                <?php if ($page > 1): ?>
                    <a href="?page=1"
                        class="px-3 py-1 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm transition">«
                        First</a>
                    <a href="?page=<?php echo $page - 1; ?>"
                        class="px-3 py-1 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm transition">‹
                        Prev</a>
                <?php endif; ?>

                <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);

                if ($start > 1) {
                    echo '<span class="px-3 py-1 text-gray-500">...</span>';
                }

                for ($i = $start; $i <= $end; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="px-3 py-1 rounded-full text-sm transition 
            <?php echo ($i == $page)
                ? 'bg-blue-600 text-white font-semibold shadow-md'
                : 'bg-gray-200 hover:bg-gray-300 text-gray-700'; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($end < $total_pages) {
                    echo '<span class="px-3 py-1 text-gray-500">...</span>';
                } ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>"
                        class="px-3 py-1 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm transition">Next
                        ›</a>
                    <a href="?page=<?php echo $total_pages; ?>"
                        class="px-3 py-1 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm transition">Last
                        »</a>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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

        const deleteModal = document.getElementById('deleteModal');
        const deleteIdInput = document.getElementById('deleteId');

        function openDeleteModal(id) {
            deleteIdInput.value = id;
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex'); // biar muncul dengan flex
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }

        // Tutup modal kalau klik area luar
        deleteModal.addEventListener('click', function (e) {
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });
    </script>
</body>

</html>