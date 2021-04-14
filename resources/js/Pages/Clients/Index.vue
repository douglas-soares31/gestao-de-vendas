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
        class="mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden pt-20"
      >
        <thead class="bg-gray-50">
          <tr>
            <th class="font-semibold text-sm uppercase px-6 py-4">Id</th>
            <th class="font-semibold text-sm uppercase px-6 py-4">Nome</th>
            <th class="font-semibold text-sm uppercase px-6 py-4">Email</th>
            <th class="font-semibold text-sm uppercase px-6 py-4">Telefone</th>
            <th class="font-semibold text-sm uppercase px-6 py-4">Endereço</th>
            <th class="font-semibold text-sm uppercase px-6 py-4">Editar</th>
            <th class="font-semibold text-sm uppercase px-6 py-4">Excluir</th>
          </tr>
        </thead>
        <tbody
          class="divide-y divide-gray-200"
          v-for="client in clients"
          :key="client.id"
        >
          <tr>
            <td class="px-6 py-4">{{ client.id }}</td>
            <td class="px-6 py-4">{{ client.name }}</td>
            <td class="px-6 py-4">{{ client.email }}</td>
            <td class="px-6 py-4">{{ client.phone }}</td>
            <td class="px-6 py-4">{{ client.address }}</td>
            <td class="px-6 py-4 text-center">
              <i class="fas fa-edit text-yellow-400"></i>
            </td>
            <td class="px-6 py-4 text-center">
              <i class="fas fa-times-circle text-red-400"></i>
            </td>
          </tr>
        </tbody>
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
  props: {
    clients: Array,
  },
};
</script>
