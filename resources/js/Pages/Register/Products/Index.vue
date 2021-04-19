<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Produtos cadastrados
        </h2>

        <inertia-link
          class="inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
          :href="route('register.products.create')"
          as="button"
          type="button"
        >
          Cadastrar Produto
        </inertia-link>
      </div>
    </template>

    <div
      class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-5 md:gap-3 space-y-3 md:space-y-0 mt-4 ml-4"
    >
      <div
        class="grid content-between shadow border rounded-lg overflow-hidden shadow-lg my-2 hover:border-pink-300"
        v-for="product in this.registerProducts"
        :key="product.id"
      >
        <img
          v-if="product.image_path"
          class="object-fill w-full"
          :src="'../storage/' + product.image_path"
        />
        <div class="px-6 py-4">
          <div class="font-bold text-xl mb-2">ID: {{ product.id }}</div>
        </div>
        <div class="flex flex-row px-6 py-4 justify-between divide-x divide-gray-300">
          <div class="px-6 py-4">
            <p class="text-grey-darker text-sm">
              {{ product.description }}
            </p>
            <p class="text-sm">Tam: <span class="font-bold">{{ product.size }}</span></p>
          </div>

          <div class="px-6 py-4">
            <p class="text-green-400 text-sm">
              Valor unitário de Compra: <span class="font-bold">{{ product.unit_purchase_value }}</span>
            </p>
            <p class="text-red-400 text-sm">
              Valor unitário de Venda: <span class="font-bold">{{ product.unit_sale_value }}</span>
            </p>
          </div>
        </div>
        <div class="px-6 py-4">
          <div class="flex justify-between">
            <inertia-link
              class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow transition ease-in-out duration-150"
              as="button"
              type="button"
              :product="product"
              @click.prevent="editarProduto(product)"
              href="#"
              preserve-state
            >
              Editar
            </inertia-link>

            <inertia-link
              class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150"
              as="button"
              type="button"
              :product="product"
              @click.prevent="excluirProduto(product)"
              href="#"
              preserve-state
            >
              Excluir
            </inertia-link>
          </div>
        </div>
      </div>
    </div>

    <div v-if="this.registerProducts.length === 0">
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
      dadosProducts: this.registerProducts,
    };
  },
  props: {
    registerProducts: Array,
  },
  methods: {
    excluirProduto(item) {
      this.$inertia.delete(
        route("register.products.remove", {
          id: item.id,
        })
      );

      this.dadosProducts = this.dadosProducts.filter(
        (product) => product !== item
      );
    },

    editarProduto(item) {
      this.$inertia.get(
        route("register.products.edit", {
          id: item.id,
        })
      );
    },
  },
};
</script>
