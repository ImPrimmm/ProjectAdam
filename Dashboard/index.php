<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Dashboard Realisasi Bankeu Parpol Jabar</title>
  <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url("https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/231/2024/07/16/Gedung-Sate-Bandung-Abah-Shutterstock-2609867939.png") no-repeat center center;
      background-size: cover;
    }

    .container {
      background-color: rgb(0, 0, 0, 0.7);
      height: 100vh;
    }

    .header {
      text-align: center;
      padding: 30px;
      background: linear-gradient(to right, black, black);
      color: white;
      height: 80px;
      display: flex;
      flex-direction: row;
      justify-content: space-around;
    }

    .containerImg {
      display: flex;
      align-items: center;
    }

    .containerImg img {
      height: 50px;
    }

    .containerImgJabar {
      width: 229.91px;
    }

    .containerImgJabar img {
      height: 80px;
    }

    .title {
      width: 700px;
    }


    .header h1 {
      margin: 0;
      font-size: 36px;
    }

    .header h2 {
      margin: 5px 0 0;
      font-size: 28px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 30px;
      padding: 30px;
      justify-items: center;
    }

    .chart-container {
      width: 220px;
      text-align: center;
      position: relative;
      background-color: rgba(255, 255, 255, 0.85);
      padding: 10px;
      border-radius: 12px;
    }

    .number-circle {
      position: absolute;
      top: 8px;
      left: 8px;
      width: 32px;
      height: 32px;
      background: black;
      color: white;
      border-radius: 50%;
      font-size: 20px;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 10;
    }

    .chart {
      width: 180px;
      height: 180px;
      margin: 0 auto;
    }

    .chart-title {
      font-weight: bold;
      font-size: 16px;
      margin-top: 10px;
      color: #000;
    }

    .chart-legend {
      margin-top: 10px;
      text-align: left;
      font-size: 13px;
    }

    .legend-item {
      display: flex;
      align-items: center;
      margin-bottom: 5px;
    }

    .legend-color {
      width: 16px;
      height: 16px;
      margin-right: 8px;
      border-radius: 3px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <span class="containerImg">
        <img src="../assets/logo kesbangpol BARU.png" alt="logo" />
      </span>
      <div class="title">
        <h1>DASHBOARD REALISASI BANKEU</h1>
        <h2>PARPOL PROV JABAR</h2>
      </div>
      <span class="containerImgJabar">
        <img src="../assets/logo_footer.png" alt="logo" height="50px">
      </span>
    </div>
    <div class="grid" id="chartGrid"></div>
  </div>

  <script>
    async function loadData() {
      try {
        const response = await fetch("getData.php");
        const data = await response.json();

        const grid = document.getElementById("chartGrid");
        grid.innerHTML = ""; // kosongkan dulu isi grid

        data.forEach((item, index) => {
          // bikin container chart
          const container = document.createElement("div");
          container.className = "chart-container";
          container.innerHTML = `
        <div class="number-circle">${index + 1}</div>
        <div id="chartdiv${index}" class="chart"></div>
        <div class="chart-title">${item.party}</div>
        <div class="chart-legend" id="legend${index}"></div>
      `;
          grid.appendChild(container);

          // render chart
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
        am5percent.PieChart.new(root, {
          layout: root.verticalLayout,
        })
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
        target.dataItem.dataContext.color ?
        am5.color(target.dataItem.dataContext.color) :
        fill
      );

      //  Tooltip custom
      let tooltip = am5.Tooltip.new(root, {
        keepTargetHover: true,
        paddingTop: 2,
        paddingBottom: 2,
        paddingLeft: 4,
        paddingRight: 4,
      });
      tooltip.label.setAll({
        fontSize: 16, // lebih kecil (default biasanya 12–14px)
        textAlign: "center",
        fill: am5.color(0x000000),
      });

      series.set("tooltip", tooltip);
      series.slices.template.set("tooltipText", "{category}: {value}%");

      series.appear(500, 100);
      chart.appear(500, 100);
    }


    // jalankan saat halaman load
    loadData();
  </script>
</body>

</html>