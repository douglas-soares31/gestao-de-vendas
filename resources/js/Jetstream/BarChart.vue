<template>
  <div class="w-full xl:w-6/12 px-4">
    <div
      class="relative flex flex-col min-w-0 break-words bg-gray-800 w-full mb-6 shadow-lg rounded"
    >
      <div class="rounded-t mb-0 px-4 py-3 bg-transparent">
        <div class="flex flex-wrap items-center">
          <div class="relative w-full max-w-full flex-grow flex-1">
            <h6 class="uppercase text-white mb-1 text-xs font-semibold">
              {{ title }}
            </h6>
            <h2 class="text-white text-xl font-semibold">
              {{ description }}
            </h2>
          </div>
        </div>
      </div>
      <div class="p-4 flex-auto">
        <!-- Chart -->
        <div class="relative" style="height: 350px">
          <canvas id="bar-chart"></canvas>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Chart from "chart.js";

export default {
  mounted: function () {
    this.$nextTick(function () {
      const meses = [
        "Jan",
        "Fev",
        "Mar",
        "Abr",
        "Mai",
        "Jun",
        "Jul",
        "Ago",
        "Set",
        "Out",
        "Nov",
        "Dez",
      ];

      console.log(this.dataChart);

      let config = {
        type: "bar",
        data: {
          labels: this.dataChart.Labels.map(function (elem) {
            let dataFormatada = new Date(elem);
            dataFormatada =
              meses[dataFormatada.getMonth()] +
              "/" +
              dataFormatada.getFullYear();
            return dataFormatada;
          }),
          datasets: [
            {
              label: "Compras",
              backgroundColor: "#ed64a6",
              borderColor: "#ed64a6",
              data: this.dataChart.Purchases.countP,
              fill: false,
              barThickness: 8,
            },
            {
              label: "Vendas",
              fill: false,
              backgroundColor: "#4c51bf",
              borderColor: "#4c51bf",
              data: this.dataChart.Sales.countS,
              barThickness: 8,
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          title: {
            display: false,
            text: "Orders Chart",
          },
          tooltips: {
            mode: "index",
            intersect: false,
          },
          hover: {
            mode: "nearest",
            intersect: true,
          },
          legend: {
            labels: {
              fontColor: "white",
            },
            align: "end",
            position: "bottom",
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  fontColor: "rgba(255,255,255,.7)",
                },
                display: true,
                scaleLabel: {
                  display: false,
                  labelString: "Month",
                  fontColor: "white",
                },
                gridLines: {
                  display: false,
                  borderDash: [2],
                  borderDashOffset: [2],
                  color: "rgba(33, 37, 41, 0.3)",
                  zeroLineColor: "rgba(0, 0, 0, 0)",
                  zeroLineBorderDash: [2],
                  zeroLineBorderDashOffset: [2],
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  fontColor: "rgba(255,255,255,.7)",
                },
                display: true,
                scaleLabel: {
                  display: false,
                  labelString: "Value",
                  fontColor: "white",
                },
                gridLines: {
                  borderDash: [3],
                  borderDashOffset: [3],
                  drawBorder: false,
                  color: "rgba(255, 255, 255, 0.15)",
                  zeroLineColor: "rgba(33, 37, 41, 0)",
                  zeroLineBorderDash: [2],
                  zeroLineBorderDashOffset: [2],
                },
              },
            ],
          },
        },
      };
      let ctx = document.getElementById("bar-chart").getContext("2d");
      window.myBar = new Chart(ctx, config);
    });
  },
  props: {
    title: String,
    description: String,
    dataChart: Array,
  },
};
</script>
