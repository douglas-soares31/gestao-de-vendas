<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Despesas cadastradas
        </h2>

        <inertia-link
          class="inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
          :href="route('register.expenses.create')"
          as="button"
          type="button"
        >
          Cadastrar Despesa
        </inertia-link>
      </div>
    </template>

    <div class="bg-gray-100 rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="font-bold text-sm uppercase px-6 py-4">Id</th>
          <th class="font-bold text-sm uppercase px-6 py-4">Descrição</th>
          <th class="font-bold text-sm uppercase px-6 py-4">Editar</th>
          <th class="font-bold text-sm uppercase px-6 py-4">Excluir</th>
        </tr>

        <tr
          v-for="expense in this.dadosExpenses"
          :key="expense.id"
          class="hover:bg-gray-200 focus-within:bg-gray-200"
        >
          <td class="border-t px-6 py-4">{{ expense.id }}</td>
          <td class="border-t px-6 py-4">{{ expense.description }}</td>
          <td class="border-t px-6 py-4">
            <inertia-link
              class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow transition ease-in-out duration-150"
              as="button"
              type="button"
              :expense="expense"
              @click.prevent="editarDespesa(expense)"
              href="#"
              preserve-state
            >
              <i class="fas fa-edit"></i>
            </inertia-link>
          </td>
          <td class="border-t px-6 py-4">
            <inertia-link
              class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150"
              as="button"
              type="button"
              :expense="expense"
              @click.prevent="excluirDespesa(expense)"
              href="#"
              preserve-state
            >
              <i class="fas fa-times-circle"></i>
            </inertia-link>
          </td>
        </tr>

        <tr v-if="this.dadosExpenses.length === 0">
          <td class="border-t px-6 py-4" colspan="8">
            Não há dados cadastrados.
          </td>
        </tr>
      </table>
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
      dadosExpenses: this.registerExpenses,
    };
  },
  props: {
    registerExpenses: Array,
  },
  methods: {
    excluirDespesa(item) {
      this.$inertia.delete(
        route("register.expenses.remove", {
          id: item.id,
        })
      );

      this.dadosExpenses = this.dadosExpenses.filter(
        (expense) => expense !== item
      );
    },

    editarDespesa(item) {
      this.$inertia.get(
        route("register.expenses.edit", {
          id: item.id,
        })
      );
    },
  },
};
</script>
