<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Cadastrar novo Produto
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
              <jet-label for="description" value="Descrição" />
              <jet-input
                id="description"
                type="text"
                class="mt-1 block w-full"
                v-model="form.description"
                required
                autofocus
              />
            </div>
            <div>
              <jet-label for="size" value="Tamanho" />
              <jet-input
                id="size"
                type="text"
                class="mt-1 block w-full"
                v-model="form.size"
                required
                autofocus
              />
            </div>

            <div>
              <jet-label for="image_path" value="Imagem do Produto" />
              <jet-input
                id="image_path"
                type="file"
                class="mt-1 block w-full"
                v-model="form.image_path"
              />
            </div>
            <progress
              v-if="form.progress"
              :value="form.progress.percentage"
              max="100"
            >
              {{ form.progress.percentage }}%
            </progress>

            <div class="flex mt-4 justify-between">
              <inertia-link
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                :href="route('register.products')"
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
      form: this.$inertia.form({
        description: null,
        size: null,
        image_path: null,
      }),
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
      this.$inertia.post(route("register.products.store"), this.form);
    },
  },
};
</script>