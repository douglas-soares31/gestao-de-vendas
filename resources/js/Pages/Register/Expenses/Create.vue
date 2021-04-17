<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Cadastrar nova Despesa
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
              <jet-label for="description" value="Descrição da Despesa" />
              <jet-input
                id="description"
                type="text"
                class="mt-1 block w-full"
                v-model="form.description"
                required
                autofocus
              />
            </div>

            <div class="flex mt-4 justify-between">
              <inertia-link
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                :href="route('register.expenses')"
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
        description: null,
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
      this.$inertia.post(route("register.expenses.store"), this.form);
    },
  },
};
</script>