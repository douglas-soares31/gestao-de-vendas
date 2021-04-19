<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Editando Produto | {{ form.id }} ( {{ form.description }} )
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
          <form @submit.prevent="submit" enctype="multipart/form-data">
            <div>
              <jet-label for="description" value="Descrição do item" />
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
              <jet-label
                for="unit_purchase_value"
                value="Preço unitário da Compra"
              />
              <jet-input
                id="unit_purchase_value"
                type="text"
                class="mt-1 block w-full"
                v-model="form.unit_purchase_value"
                required
                autofocus
              />
            </div>

            <div>
              <jet-label
                for="unit_sale_value"
                value="Preço unitário da Venda"
              />
              <jet-input
                id="unit_sale_value"
                type="text"
                class="mt-1 block w-full"
                v-model="form.unit_sale_value"
                required
                autofocus
              />
            </div>

            <!-- Profile Photo File Input -->
            <input
              type="file"
              class="hidden"
              ref="image_path"
              @change="updatePhotoPreview"
            />

            <jet-label for="image_path" value="Imagem" />

            <div class="mt-2" v-show="!photoPreview">
              <img
                :src="imageStorage"
                :alt="form.description"
                class="rounded-full h-20 w-20 object-cover"
              />
            </div>

            <!-- New Profile Photo Preview -->
            <div class="mt-2" v-show="photoPreview">
              <span
                class="block rounded-full w-20 h-20"
                :style="
                  'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
                  photoPreview +
                  '\');'
                "
              >
              </span>
            </div>

            <jet-secondary-button
              class="mt-2 mr-2"
              type="button"
              @click.prevent="selectNewPhoto"
            >
              Selecionar imagem
            </jet-secondary-button>

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
                Editar
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
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetInputError from "@/Jetstream/InputError";

export default {
  data() {
    return {
      form: this.$inertia.form({
        _method: "PUT",
        id: this.registerProducts.id,
        description: this.registerProducts.description,
        size: this.registerProducts.size,
        unit_purchase_value: this.registerProducts.unit_purchase_value,
        unit_sale_value: this.registerProducts.unit_sale_value,
        image_path: this.registerProducts.image_path,
      }),
      photoPreview: null,
      imageStorage:
        "../../../../../storage/" + this.registerProducts.image_path,
    };
  },
  props: {
    registerProducts: Object,
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
    JetSecondaryButton,
    JetInputError,
  },
  methods: {
    submit() {
      if (this.$refs.image_path) {
        this.form.image_path = this.$refs.image_path.files[0];
      }

      this.$inertia.post(
        route("register.products.update", {
          id: this.registerProducts.id,
        }),
        this.form
      );
    },

    selectNewPhoto() {
      this.$refs.image_path.click();
    },

    updatePhotoPreview() {
      const reader = new FileReader();

      reader.onload = (e) => {
        this.photoPreview = e.target.result;
      };

      reader.readAsDataURL(this.$refs.image_path.files[0]);
    },
  },
};
</script>