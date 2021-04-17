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
      class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-6 md:gap-4 space-y-4 md:space-y-0 mt-4"
    >
      <div
        class="flex flex-wrap content-between shadow border rounded-lg"
        v-for="product in this.registerProducts"
        :key="product.id"
      >
        <div class="flex items-center space-x-4 p-4">
          <div
            class="flex items-center p-4 bg-purple-600 text-white rounded-lg"
          >
            <img v-if="product.image_path" class="object-scale-down h-16 w-30">
          </div>
          <div class="flex-1">
            <p class="text-gray-500 font-semibold">ID: {{ product.id }}</p>
            <div class="flex items-baseline space-x-4">
              <p>Descrição:</p>
              <h2 class="text-2xl font-semibold">{{ product.description }}</h2>
            </div>

            <div class="flex items-baseline space-x-4">
              <p class="text-green-700 flex font-semibold space-x-1">
                Tamanho: <span class="font-bold">{{ product.size }}</span>
              </p>
            </div>
          </div>
        </div>
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
