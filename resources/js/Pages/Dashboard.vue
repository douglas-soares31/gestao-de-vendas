<template>
  <app-layout>
    <div>
      <div class="bg-blueGray-100">
        <!-- Header -->
        <div class="relative bg-white pt-10 pb-32">
          <div class="px-4 md:px-10 mx-auto w-full">
            <div>
              <!-- Card stats -->
              <div class="flex flex-wrap">
                <div
                  class="w-full lg:w-6/12 xl:w-6/12 px-4 transform transition duration-500 hover:scale-110"
                >
                  <div
                    class="relative flex flex-col min-w-0 break-words bg-gray-800 text-white rounded mb-6 xl:mb-0 shadow-lg"
                  >
                    <div class="flex-auto p-4">
                      <div class="flex flex-wrap">
                        <div
                          class="relative w-full pr-4 max-w-full flex-grow flex-1"
                        >
                          <h5
                            class="text-blueGray-400 uppercase font-bold text-xs"
                          >
                            Vendas computadas
                          </h5>
                          <span class="font-semibold text-xl text-blueGray-700">
                            {{ arraySales.countSales }}
                          </span>
                        </div>
                        <div class="relative w-auto pl-4 flex-initial">
                          <div
                            class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500"
                          >
                            <i class="far fa-chart-bar"></i>
                          </div>
                        </div>
                      </div>
                      <p class="text-sm text-blueGray-400 mt-4">
                        <span class="text-green-500 mr-2">
                          <i class="fas fa-arrow-up"></i>
                          {{ arraySales.percSalesLastMonth }}%
                        </span>
                        <span class="whitespace-nowrap">
                          Nos últimos 30 dias
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
                <div
                  class="w-full lg:w-6/12 xl:w-6/12 px-4 transform transition duration-500 hover:scale-110"
                >
                  <div
                    class="relative flex flex-col min-w-0 break-words bg-gray-800 text-white rounded mb-6 xl:mb-0 shadow-lg"
                  >
                    <div class="flex-auto p-4">
                      <div class="flex flex-wrap">
                        <div
                          class="relative w-full pr-4 max-w-full flex-grow flex-1"
                        >
                          <h5
                            class="text-blueGray-400 uppercase font-bold text-xs"
                          >
                            Clientes cadastrados
                          </h5>
                          <span class="font-semibold text-xl text-blueGray-700">
                            {{ countClients }}
                          </span>
                        </div>
                        <div class="relative w-auto pl-4 flex-initial">
                          <div
                            class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-pink-500"
                          >
                            <i class="fas fa-users"></i>
                          </div>
                        </div>
                      </div>
                      <p class="text-sm text-blueGray-400 mt-4">
                        <span class="text-orange-500 mr-2"></span>
                        <span class="whitespace-nowrap"></span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="px-4 md:px-10 mx-auto w-full -m-24">
          <div class="flex flex-wrap">
            <line-chart-component
              title="Comparativo Compras vs Vendas"
              description="Valores (R$)"
              :dataChart="dataSalesPurchases"
            >
            </line-chart-component>
            <bar-chart-component
              title="Comparativo Compras vs Vendas"
              description="Quantidade (Ordens)"
              :dataChart="dataSalesPurchases"
            ></bar-chart-component>
          </div>
          <div class="flex flex-wrap mt-4">
            <div class="w-full xl:w-6/12 mb-12 xl:mb-0 px-4">
              <div
                class="relative flex flex-col min-w-0 break-words bg-gray-800 text-white w-full mb-6 shadow-lg rounded"
              >
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                  <div class="flex flex-wrap items-center">
                    <div
                      class="relative w-full px-4 max-w-full flex-grow flex-1"
                    >
                      <h3 class="font-semibold text-base text-blueGray-700">
                        Lista dos itens com maior receita
                      </h3>
                    </div>
                  </div>
                </div>
                <div class="block w-full overflow-x-auto">
                  <!-- Projects table -->
                  <table
                    class="items-center w-full bg-transparent border-collapse"
                  >
                    <thead>
                      <tr>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                        >
                          #
                        </th>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                        >
                          Item
                        </th>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                        >
                          Tamanho
                        </th>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                        >
                          Valor Total
                        </th>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                        >
                          %
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in itemsSales" :key="item.id">
                        <th
                          class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
                        >
                          {{ item.id }}
                        </th>
                        <td
                          class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                        >
                          {{ item.description }}
                        </td>
                        <td
                          class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                        >
                          {{ item.size }}
                        </td>
                        <td
                          class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                        >
                          {{ formatterBR.format(item.totalAmount) }}
                        </td>
                        <td
                          class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                        >
                          {{ formatterPercent.format(item.percAmount) }}%
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="w-full xl:w-6/12 px-4">
              <div
                class="relative flex flex-col min-w-0 break-words bg-gray-800 text-white w-full mb-6 shadow-lg rounded"
              >
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                  <div class="flex flex-wrap items-center">
                    <div
                      class="relative w-full px-4 max-w-full flex-grow flex-1"
                    >
                      <h3 class="font-semibold text-base text-blueGray-700">
                        Lista dos itens com maior fluxo de saídas
                      </h3>
                    </div>
                  </div>
                </div>
                <div class="block w-full overflow-x-auto">
                  <!-- Projects table -->
                  <table
                    class="items-center w-full bg-transparent border-collapse"
                  >
                    <thead>
                      <tr>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                        >
                          #
                        </th>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                        >
                          Item
                        </th>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                        >
                          Tamanho
                        </th>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                        >
                          Quantidade Total
                        </th>
                        <th
                          class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                        >
                          %
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in itemsSales" :key="item.id">
                        <th
                          class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
                        >
                          {{ item.id }}
                        </th>
                        <td
                          class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                        >
                          {{ item.description }}
                        </td>
                        <td
                          class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                        >
                          {{ item.size }}
                        </td>
                        <td
                          class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                        >
                          {{ item.totalQuantity }}
                        </td>
                        <td
                          class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                        >
                          {{ formatterPercent.format(item.percQuantity) }}%
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout";
import NavbarComponent from "@/Jetstream/Navbar.vue";
import SidebarComponent from "@/Jetstream/Sidebar.vue";
import LineChartComponent from "@/Jetstream/LineChart.vue";
import BarChartComponent from "@/Jetstream/BarChart.vue";
export default {
  name: "dashboard-page",
  components: {
    NavbarComponent,
    SidebarComponent,
    LineChartComponent,
    BarChartComponent,
    AppLayout,
  },
  data() {
    return {
      date: new Date().getFullYear(),
      formatterBR: new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
        minimumFractionDigits: 2,
      }),
      formatterPercent: new Intl.NumberFormat("pt-BR", {
        minimumFractionDigits: 2,
      }),
    };
  },

  props: {
    countClients: BigInt,
    arraySales: Array,
    dataSalesPurchases: Array,
    itemsSales: Array,
  },
};
</script>
