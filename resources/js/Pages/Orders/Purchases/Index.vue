<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Registros de Compras
        </h2>

        <inertia-link
          class="inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
          :href="route('purchases.create')"
          as="button"
          type="button"
        >
          Cadastrar nova Compra
        </inertia-link>
      </div>
    </template>

    <div
      class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-5 md:gap-3 space-y-3 md:space-y-0 mt-4 ml-4"
    >
      <div
        class="grid content-between shadow border rounded-lg overflow-hidden shadow-lg my-2 hover:border-pink-300"
        v-for="purchase in this.dadosCompras"
        :key="purchase.id"
      >
        <div class="px-6 py-4">
          <div class="font-bold text-xl mb-2"># {{ purchase.id }}</div>
        </div>
        <div class="flex flex-row px-6 py-4 justify-between divide-x divide-gray-300">
          <div class="px-6 py-4">
            <p class="text-grey-darker text-sm">
              {{ purchase.name }}
            </p>
            <p class="text-sm">Tam: <span class="font-bold">{{ purchase.size }}</span></p>
          </div>

          <div class="px-6 py-4">
            <p class="text-green-400 text-sm">
              Valor unitário de Compra: <span class="font-bold">{{ purchase.unit_purchase_value }}</span>
            </p>
            <p class="text-red-400 text-sm">
              Valor unitário de Venda: <span class="font-bold">{{ purchase.unit_order_value }}</span>
            </p>
          </div>
        </div>
        <div class="px-6 py-4">
          <div class="flex justify-between">
            <inertia-link
              class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow transition ease-in-out duration-150"
              as="button"
              type="button"
              :purchase="purchase"
              @click.prevent="editarCompra(purchase)"
              href="#"
              preserve-state
            >
              Editar
            </inertia-link>

            <inertia-link
              class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150"
              as="button"
              type="button"
              :purchase="purchase"
              @click.prevent="excluirCompra(purchase)"
              href="#"
              preserve-state
            >
              Excluir
            </inertia-link>
          </div>
        </div>
      </div>
    </div>

    <div v-if="this.dadosCompras.length === 0">
      <td class="w-full">Não há compras cadastradas.</td>
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
      dadosCompras: this.purchasesOrders,
    };
  },
  props: {
    purchasesOrders: Array,
  },
  methods: {
    excluirCompra(item) {
      this.$inertia.delete(
        route("purchases.remove", {
          id: item.id,
        })
      );

      this.dadosCompras = this.dadosCompras.filter(
        (purchase) => purchase !== item
      );
    },

    editarCompra(item) {
      this.$inertia.get(
        route("purchases.edit", {
          id: item.id,
        })
      );
    },
  },
};
</script>
