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
        <div class="grid grid-rows-4 grid-flow-col gap-2">
          <p class="font-bold justify-self-center">ID</p>
          <span class="justify-self-center">
            #{{ stock.register_product_id }}
          </span>
          <p class="font-bold justify-self-center">Descrição</p>
          <span class="text-grey-darker text-sm">
            {{ stock.description }}
          </span>
          <p class="font-bold justify-self-center">Tamanho</p>
          <span class="justify-self-center">{{ stock.size }}</span>
          <p class="font-bold justify-self-center">QTD disponível</p>
          <span class="text-green-500 justify-self-center">{{
            stock.quantity
          }}</span>
        </div>
      </div>
    </div>

    <div v-if="this.dadosStocks.length === 0">
      <td class="w-full">Não há estoque disponível.</td>
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
