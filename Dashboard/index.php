<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Dashboard Realisasi Bankeu Parpol Jabar</title>
  <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans bg-gray-100">
  <!-- Background -->
  <div class="relative min-h-screen bg-cover bg-center" style="background-image: url('../assets/adam-bg.jpeg');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/70"></div>

    <!-- Container utama -->
    <div class="relative z-10 flex flex-col min-h-screen">

      <!-- Header -->
      <header class="relative flex items-center justify-between px-6 md:px-12 py-4 bg-gray-200">

        <!-- Logo kiri -->
        <div class="flex-shrink-0">
          <img src="../assets/logo kesbangpol BARU.png" alt="logo" class="h-16">
        </div>

        <!-- Judul tengah -->
        <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
          <h1 class="text-black text-2xl md:text-3xl font-bold leading-tight">
            DASHBOARD REALISASI BANKEU
          </h1>
          <h2 class="text-black text-lg md:text-xl mt-1 font-medium">
            PARPOL PROV JABAR
          </h2>
        </div>

        <!-- Tombol hamburger di kanan -->
        <button onclick="openNav()" class="ml-auto text-gray-900 hover:text-gray-400 focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </header>

      <!-- Drawer kanan -->
      <div id="mySidenav"
        class="fixed right-0 top-0 h-full w-0 bg-gray-200 text-white overflow-x-hidden transition-all duration-300 z-50 flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
          <img src="../assets/logo kesbangpol BARU.png" class="w-[200px]">
          <button onclick="closeNav()"
            class="text-gray-400 hover:text-white text-2xl focus:outline-none transition-colors duration-200">
            &times;
          </button>
        </div>

        <!-- Menu -->
        <div class="">
          <a href="../index.php" class="block py-3 px-4 text-black rounded-lg hover:bg-gray-300 hover:text-gray-600 transition-colors duration-200">Home</a>
          <a href="#" class="block py-3 px-4 text-black rounded-lg hover:bg-gray-300 hover:text-gray-600 transition-colors duration-200">Struktur
            Organisasi</a>
        </div>
      </div>

      <!-- Grid chart -->
      <main class="flex-1 p-8">
        <div id="chartGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6"></div>
      </main>
    </div>
  </div>

  <script>
    async function loadData() {
      try {
        const response = await fetch("getData.php");
        const data = await response.json();

        const grid = document.getElementById("chartGrid");
        grid.innerHTML = "";

        data.forEach((item, index) => {
          const container = document.createElement("div");
          container.className = "relative bg-white/80 rounded-lg p-4 text-center";

          container.innerHTML = `
            <div class="absolute top-2 left-2 w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold">${index + 1}</div>
            <div id="chartdiv${index}" class="w-44 h-44 mx-auto"></div>
            <div class="mt-2 font-semibold text-black">${item.party}</div>
            <div id="legend${index}" class="mt-2 text-left text-sm"></div>
          `;

          grid.appendChild(container);
          createDonutChart("chartdiv" + index, "legend" + index, item.chartData);
        });
      } catch (error) {
        console.error("Gagal ambil data:", error);
      }
    }

    function createDonutChart(divId, legendId, chartData) {
      let root = am5.Root.new(divId);
      root.setThemes([am5themes_Animated.new(root)]);

      let chart = root.container.children.push(
        am5percent.PieChart.new(root, { layout: root.verticalLayout })
      );

      let series = chart.series.push(
        am5percent.PieSeries.new(root, {
          valueField: "value",
          categoryField: "category",
          innerRadius: am5.percent(50),
        })
      );

      series.data.setAll(chartData);

      series.slices.template.adapters.add("fill", (fill, target) =>
        target.dataItem.dataContext.color ? am5.color(target.dataItem.dataContext.color) : fill
      );

      let tooltip = am5.Tooltip.new(root, { keepTargetHover: true, paddingTop: 2, paddingBottom: 2, paddingLeft: 4, paddingRight: 4 });
      tooltip.label.setAll({ fontSize: 16, textAlign: "center", fill: am5.color(0x000000) });

      series.set("tooltip", tooltip);
      series.slices.template.set("tooltipText", "{category}: {value}%");

      series.appear(500, 100);
      chart.appear(500, 100);
    }

    loadData();

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
  </script>
</body>

</html>