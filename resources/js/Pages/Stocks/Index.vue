<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Estoque
        </h2>
      </div>
    </template>

    <div
      class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-5 md:gap-3 space-y-3 md:space-y-0 mt-4 ml-4"
    >
      <div
        class="grid content-between shadow border rounded-lg overflow-hidden shadow-lg my-2 hover:border-pink-300"
        v-for="stock in this.dadosStocks"
        :key="stock.id"
      >
        <img
          v-if="stock.image_path"
          class="object-fill w-full"
          :src="'../storage/' + stock.image_path"
        />
        <div class="px-6 py-4">
          <div class="font-bold text-xl mb-2">
            # {{ stock.register_product_id }}
          </div>
          <p class="text-grey-darker text-sm">
            {{ stock.description }}
          </p>
        </div>
        <div
          class="flex flex-row px-6 py-4 justify-between divide-x divide-gray-300"
        >
          <div class="px-6 py-4">
            <p class="text-sm">
              Tam: <span class="font-bold">{{ stock.size }}</span>
            </p>
          </div>

          <div class="px-6 py-4">
            <p class="text-green-400 text-sm">
              Quantidade disponível:
              <span class="font-bold">{{ stock.quantity }}</span>
            </p>
          </div>
        </div>
      </div>
    </div>

    <div v-if="this.dadosStocks.length === 0">
      <td class="w-full">Não há dados cadastrados.</td>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
export default {
  components: {
    AppLayout,
    JetButton,
  },
  data() {
    return {
      dadosStocks: this.dataStocks,
    };
  },
  props: {
    dataStocks: Array,
  },
  methods: {},
};
</script>
