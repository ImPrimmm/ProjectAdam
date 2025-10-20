<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="m-0 font-sans h-screen bg-cover bg-center" style="background-image: url('../assets/adam-bg.jpeg');">

  <!-- Overlay hitam -->
  <div class="absolute inset-0 bg-black/70"></div>

  <!-- Container utama -->
  <div class="relative z-10 grid grid-rows-[80px_1fr] h-screen">

    <!-- Header -->
    <header class="flex items-center justify-between px-6 md:px-12 py-4 bg-gray-300 relative">
      <!-- Logo -->
      <span class="flex items-center">
        <img src="./assets/logo kesbangpol BARU.png" alt="logo" class="h-12">
      </span>

      <!-- Menu (desktop) -->
      <ul class="hidden md:flex items-center gap-9 list-none m-0 p-0 text-black">
        <li class="text-lg hover:text-gray-500 cursor-pointer"><a href="#">Home</a></li>
        <li class="text-lg hover:text-gray-500 cursor-pointer"><a href="#">Struktur Organisasi</a></li>
        <li class="text-lg hover:text-gray-500 cursor-pointer"><a href="./Dashboard/index.php">Dashboard</a></li>
        <li>
          <a href="/admin_SW1Qb3NzaWJsZU1jNzY3_/index.php">
            <button
              class="border-2 border-black rounded-lg px-4 py-1 font-bold hover:bg-black hover:text-white transition">
              Login
            </button>
          </a>
        </li>
      </ul>

      <!-- Hamburger (mobile) -->
      <button id="menu-btn" class="md:hidden focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-black" fill="none" viewBox="0 0 24 24"
          stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Mobile Menu (drawer dropdown) -->
      <div id="mobile-menu"
        class="hidden absolute top-full right-0 w-full bg-gray-200 shadow-md flex-col text-black md:hidden">
        <a href="#" class="block px-6 py-3 hover:bg-gray-300">Home</a>
        <a href="#" class="block px-6 py-3 hover:bg-gray-300">Struktur Organisasi</a>
        <a href="./Dashboard/index.php" class="block px-6 py-3 hover:bg-gray-300">Dashboard</a>
        <a href="/admin_SW1Qb3NzaWJsZU1jNzY3_/index.php" class="block px-6 py-3 hover:bg-gray-300 font-bold">Login</a>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex flex-col justify-center items-center text-center text-white px-6">
      <h1 class="text-5xl md:text-6xl font-bold mb-5">POLITIK DALAM NEGERI</h1>
      <p class="text-base md:text-lg leading-relaxed max-w-3xl">
        Bidang Politik Dalam Negeri Mempunyai Tugas Pokok Menyelenggarakan<br>
        Fungsi Penunjang Pemerintah Bidang Kesatuan Bangsa <br> Aspek Politik Dalam Negeri
      </p>
    </main>

  </div>

  <script>
  const menuBtn = document.getElementById("menu-btn");
  const mobileMenu = document.getElementById("mobile-menu");

  menuBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
  });
</script>


</body>

</html>