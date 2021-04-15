<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Clientes cadastrados
        </h2>

        <inertia-link
          class="inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
          :href="route('clients.create')"
          as="button"
          type="button"
        >
          Cadastrar Cliente
        </inertia-link>
      </div>
    </template>
    <div class="pt-20">
      <table
        class="mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden"
        v-if="this.dadosClientes.length"
      >
        <thead class="bg-gray-50">
          <tr>
            <th class="font-bold text-sm uppercase px-6 py-4">Id</th>
            <th class="font-bold text-sm uppercase px-6 py-4">Nome</th>
            <th class="font-bold text-sm uppercase px-6 py-4">Email</th>
            <th class="font-bold text-sm uppercase px-6 py-4">Telefone</th>
            <th class="font-bold text-sm uppercase px-6 py-4">Endereço</th>
            <th class="font-bold text-sm uppercase px-6 py-4">Editar</th>
            <th class="font-bold text-sm uppercase px-6 py-4">Excluir</th>
          </tr>
        </thead>
        <tbody
          class="divide-y divide-gray-200"
          v-for="client in this.dadosClientes"
          :key="client.id"
        >
          <tr>
            <td class="px-6 py-4">{{ client.id }}</td>
            <td class="px-6 py-4">{{ client.name }}</td>
            <td class="px-6 py-4">{{ client.email }}</td>
            <td class="px-6 py-4">{{ client.phone }}</td>
            <td class="px-6 py-4">{{ client.address }}</td>
            <td class="px-6 py-4 text-center">
              <inertia-link
                class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow transition ease-in-out duration-150"
                as="button"
                type="button"
                @click="editarCliente(client.id)"
                href="#"
              >
                <i class="fas fa-edit"></i>
              </inertia-link>
            </td>
            <td class="px-6 py-4 text-center">
              <inertia-link
                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150"
                as="button"
                type="button"
                :client="client"
                @click.prevent="excluirCliente(client)"
                href="#"
                preserve-state
              >
                <i class="fas fa-times-circle"></i>
              </inertia-link>
            </td>
          </tr>
        </tbody>
      </table>

      <div
        v-else
        class="bg-gray-200 border-l-4 border-gray-600 text-gray-400 p-4 pt-20"
        role="alert"
      >
        <p class="font-bold"><i class="fas fa-exclamation-triangle"></i></p>
        <p>Não há dados para exibição.</p>
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
      dadosClientes: this.clients,
    };
  },
  props: {
    clients: Array,
  },
  methods: {
    excluirCliente(item) {
      
      this.$inertia.post(
        route("clients.remove", {
          id: item.id,
        })
      );

      this.dadosClientes = this.dadosClientes.filter(
        (client) => client !== item
      );
    },
  },
};
</script>
