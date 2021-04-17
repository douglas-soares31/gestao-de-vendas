<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Cadastrar novo Fornecedor
        </h2>
      </div>
    </template>
    <div>
      <jet-validation-errors class="mb-4" />

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
      </div>

      <jet-form-card>
        <template #form>
          <form @submit.prevent="submit">
            <div>
              <jet-label for="name" value="Nome" />
              <jet-input
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
              />
            </div>

            <div>
              <jet-label for="phone" value="Telefone" />
              <jet-input
                id="phone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
                required
                autofocus
              />
            </div>

            <div>
              <jet-label for="address" value="Endereço" />
              <textarea
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                id="address"
                v-model="form.address"
              >
              </textarea>
            </div>

            <div class="flex mt-4 justify-between">
              <inertia-link
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                :href="route('providers')"
                as="button"
                type="button"
              >
                Voltar
              </inertia-link>

              <jet-button
                class="ml-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Cadastrar
              </jet-button>
            </div>
          </form>
        </template>
      </jet-form-card>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Textarea from "@/Jetstream/Textarea";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";
import JetFormCard from "@/Jetstream/FormCard";
import JetTextarea from "@/Jetstream/Textarea";

export default {
  data() {
    return {
      form: {
        name: null,
        phone: null,
        address: null,
      },
    };
  },
  components: {
    AppLayout,
    Textarea,
    JetButton,
    JetInput,
    JetCheckbox,
    JetLabel,
    JetValidationErrors,
    JetFormCard,
    JetTextarea,
  },
  methods: {
    submit() {
      this.$inertia.post(route("providers.store"), this.form);
    },
  },
};
</script>