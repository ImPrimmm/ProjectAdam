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

<body class="bg-gray-100 font-sans bg-cover bg-no-repeat" style="background-image: url('../assets/adam-bg.jpeg');">

    <!-- Navbar -->
    <header class="bg-[#F9FAFB] text-white text-white shadow-lg">
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

        <!-- Logout -->
        <div class="p-4 border-t border-gray-700">
            <a href="logout.php"
                class="block w-full text-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">
                Logout
            </a>
        </div>
    </div>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl bg-[#F9FAFB] p-4 text-black rounded-xl font-semibold">Data Realisasi</h2>

            <a href="create.php"
                class="flex items-center px-4 py-2 bg-white/20 backdrop-blur-md hover:bg-white/30 text-white/90 rounded-lg shadow transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Data
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="w-full text-sm border-collapse">
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
                    <?php
                    if (mysqli_num_rows($result) > 0):
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)):
                            ?>
                            <tr class="border-b hover:bg-gray-200">
                                <td class="text-center py-6"><?php echo $no; ?></td>
                                <td class="text-center py-6"><?php echo $row['partai']; ?></td>
                                <td class="text-center py-6"><?php echo $row['pendidikan_politik']; ?></td>
                                <td class="text-center py-6"><?php echo $row['kesektariatan']; ?></td>
                                <td class="text-center py-6 relative">
                                    <!-- Dropdown Action -->
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

                                        <!-- Modal -->
                                        <div id="deleteModal"
                                            class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                            <div class="bg-white p-6 rounded shadow-lg">
                                                <p class="mb-4">Yakin ingin menghapus data ini?</p>
                                                <div class="flex justify-end space-x-2">
                                                    <button onclick="closeDeleteModal()"
                                                        class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                                                    <a id="confirmDeleteBtn" href="#"
                                                        class="px-4 py-2 bg-red-600 text-white rounded">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $no++;
                        endwhile;
                    else:
                        ?>
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
            deleteModal.classList.add('flex');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }

        deleteModal.addEventListener('click', function (e) {
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });

        function openDeleteModal(id) {
            const modal = document.getElementById('deleteModal');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            confirmBtn.href = "delete.php?id=" + id;
            modal.classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</body>

</html>