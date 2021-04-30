<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Alterando Compra | # {{ form.id }}
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
            <div class="grid grid-cols-2 gap-4">
              <div>
                <div class="mt-2">
                  <jet-label for="provider_id" value="Fornecedor" />

                  <select
                    v-model="form.provider_id"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                    required
                  >
                    <option disabled value="">Escolha o Fornecedor</option>
                    <option
                      v-for="provider in this.providers"
                      :key="provider.id"
                      :value="provider.id"
                    >
                      {{ provider.name }}
                    </option>
                  </select>
                </div>

                <div class="mt-2">
                  <jet-label for="request_date" value="Data do Pedido" />
                  <jet-input
                    id="request_date"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.request_date"
                    required
                    autofocus
                  />
                </div>

                <div class="mt-2">
                  <jet-label
                    for="entry_date"
                    value="Data de Entrada do Produto"
                  />
                  <jet-input
                    id="entry_date"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.entry_date"
                    required
                    autofocus
                  />
                </div>

                <div class="mt-2">
                  <jet-label for="paided_at" value="Data do Pagamento" />
                  <jet-input
                    id="paided_at"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.paided_at"
                    required
                    autofocus
                  />
                </div>

                <div class="mt-2">
                  <jet-label for="payment_form" value="Forma de Pagamento" />

                  <select
                    v-model="form.payment_form"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                    required
                  >
                    <option disabled value="">
                      Escolha a Forma de Pagamento
                    </option>
                    <option value="Dinheiro" selected>Dinheiro</option>
                    <option value="Transferência Bancária">
                      Transferência Bancária
                    </option>
                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                    <option value="Cartão de Débito">Cartão de Débito</option>
                  </select>
                </div>

                <div class="flex mt-4 justify-between">
                  <inertia-link
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                    :href="route('purchases')"
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
                    Atualizar
                  </jet-button>
                </div>
              </div>

              <div>
                <div class="mt-5">
                  <jet-button
                    class="inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green transition ease-in-out duration-150"
                    @click="confirmAddItem($event)"
                  >
                    <i class="fas fa-plus"></i>
                    <span class="ml-2">Inserir item ao pedido</span>
                  </jet-button>
                </div>

                <jet-dialog-modal :show="addItemOrder" @close="closeModal">
                  <template #title> Inserir produto no pedido </template>

                  <template #content>
                    <div class="mt-2">
                      <jet-label for="register_product_id" value="Produto" />

                      <select
                        v-model="dataItem.register_product_id"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                        @change="updateUnitaryValue"
                        id="product"
                      >
                        <option disabled value="">Escolha o Produto</option>
                        <option
                          v-for="product in this.products"
                          :key="product.id"
                          :value="product.id"
                        >
                          # {{ product.id }} - {{ product.description }}
                        </option>
                      </select>
                    </div>

                    <div class="mt-2">
                      <jet-label for="quantity" value="Quantidade" />
                      <jet-input
                        id="quantity"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="dataItem.quantity"
                        required
                        autofocus
                        @keyup="updateTotalItem"
                      />
                    </div>

                    <div class="mt-2">
                      <jet-label for="unitary_value" value="Valor unitário" />
                      <jet-input
                        id="unitary_value"
                        type="text"
                        class="mt-1 block w-full"
                        v-model.lazy="dataItem.unitary_value"
                        v-money="money"
                        v-model="dataItem.unitary_value"
                        required
                        autofocus
                        @keyup="updateTotalItem"
                        @change="updateTotalItem"
                      />
                    </div>

                    <p class="text-green-400 mt-2">
                      Valor total do item:
                      <span class="font-bold" v-bind="money">
                        {{
                          formatterBR.format(dataItem.total_value_item)
                        }}</span
                      >
                    </p>
                  </template>

                  <template #footer>
                    <jet-secondary-button @click="closeModal">
                      Cancelar
                    </jet-secondary-button>

                    <jet-button
                      class="inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green transition ease-in-out duration-150"
                      @click="insertItem"
                      :disabled="form.processing"
                    >
                      Confirmar
                    </jet-button>
                  </template>
                </jet-dialog-modal>

                <div class="bg-gray-100 rounded-lg shadow-lg overflow-x-auto">
                  <table
                    class="w-full whitespace-nowrap"
                    v-if="form.purchase_items.length > 0"
                  >
                    <tr class="text-left font-bold">
                      <th class="font-bold text-sm uppercase px-6 py-4">#</th>
                      <th class="font-bold text-sm uppercase px-6 py-4">
                        Descrição
                      </th>
                      <th class="font-bold text-sm uppercase px-6 py-4">
                        Quantidade
                      </th>
                      <th class="font-bold text-sm uppercase px-6 py-4">
                        Valor unitário
                      </th>
                      <th class="font-bold text-sm uppercase px-6 py-4">
                        Valor total do item
                      </th>
                      <th class="font-bold text-sm uppercase px-6 py-4">
                        Excluir
                      </th>
                    </tr>

                    <tr
                      v-for="item in form.purchase_items"
                      :key="item.register_product_id"
                      class="hover:bg-gray-200 focus-within:bg-gray-200"
                    >
                      <td class="border-t px-6 py-4">
                        {{ item.register_product_id }}
                      </td>
                      <td class="border-t px-6 py-4">
                        {{ item.description }}
                      </td>
                      <td class="border-t px-6 py-4">
                        {{ item.quantity }}
                      </td>
                      <td class="border-t px-6 py-4">
                        {{ formatterBR.format(item.unitary_value) }}
                      </td>
                      <td class="border-t px-6 py-4">
                        {{ formatterBR.format(item.total_item_value) }}
                      </td>
                      <td class="border-t px-6 py-4">
                        <i
                          class="fas fa-times text-red-700 cursor-pointer"
                          @click="removeItem(item)"
                        ></i>
                      </td>
                    </tr>

                    <tr>
                      <td
                        class="font-bold text-sm uppercase px-6 py-4 text-right"
                        colspan="4"
                      >
                        Valor Total do Pedido:
                      </td>
                      <td class="border-t px-6 py-4">
                        {{ formatterBR.format(form.subtotal) }}
                      </td>
                    </tr>
                  </table>

                  <div v-else>Nenhum item inserido.</div>
                </div>
              </div>
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
import JetDialogModal from "@/Jetstream/DialogModal";
import JetFormSection from "@/Jetstream/FormSection";
import { VMoney } from "v-money";

export default {
  data() {
    return {
      form: this.$inertia.form({
        id: this.purchaseOrder.id,
        provider_id: this.purchaseOrder.provider_id,
        request_date: this.purchaseOrder.request_date.slice(0, 10),
        entry_date: this.purchaseOrder.entry_date.slice(0, 10),
        paided_at: this.purchaseOrder.paided_at.slice(0, 10),
        payment_form: this.purchaseOrder.payment_form,
        purchase_items: this.purchaseItems,
        subtotal: this.purchaseOrder.amount,
      }),

      dataItem: {
        id: null,
        register_product_id: null,
        description: null,
        quantity: 0,
        unitary_value: 0,
        total_value_item: 0,
      },
      addItemOrder: false,
      money: {
        decimal: ",",
        thousands: ".",
        prefix: "R$ ",
        suffix: "",
        precision: 2,
        masked: true /* doesn't work with directive */,
      },
      formatterBR: new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
        minimumFractionDigits: 2,
      }),
    };
  },
  props: {
    purchaseOrder: Array,
    purchaseItems: Array,
    providers: Array,
    products: Array,
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
    JetDialogModal,
    JetFormSection,
  },
  directives: { money: VMoney },
  methods: {
    submit() {
      if (!this.form.purchase_items.length) {
        this.$page.props.errors = ["Nenhum item inserido."];
        return false;
      }

      this.$inertia.post(
        route("purchases.update", {
          id: this.form.id,
        }),
        this.form
      );
    },

    confirmAddItem(event) {
      event.preventDefault();
      this.addItemOrder = true;
    },

    closeModal() {
      this.addItemOrder = false;
    },

    updateTotalItem() {
      let unitary_value_formated = this.dataItem.unitary_value;

      unitary_value_formated = unitary_value_formated.replaceAll("R$ ", "");
      unitary_value_formated = unitary_value_formated.replaceAll(".", "");
      unitary_value_formated = unitary_value_formated.replaceAll(",", ".");

      this.dataItem.total_value_item =
        this.dataItem.quantity * unitary_value_formated;
    },

    updateUnitaryValue() {
      var value_unit = 0;

      const idProduct = document.getElementById("product").value;

      const arrayProd = this.products.filter(function (product) {
        if (product.id == idProduct) {
          value_unit = product.unit_purchase_value;
        }
      });

      value_unit = value_unit.toFixed(2);

      this.dataItem.unitary_value = value_unit;
    },

    insertItem() {
      var descriptionProd = "";
      const idProduct = document.getElementById("product").value;

      const arrayProd = this.products.filter(function (product) {
        if (product.id == idProduct) {
          descriptionProd = product.description;
        }
      });

      let unitary_value_formated = this.dataItem.unitary_value;

      unitary_value_formated = unitary_value_formated.replaceAll("R$ ", "");
      unitary_value_formated = unitary_value_formated.replaceAll(".", "");
      unitary_value_formated = unitary_value_formated.replaceAll(",", ".");

      this.form.purchase_items.push({
        register_product_id: this.dataItem.register_product_id,
        description: descriptionProd,
        quantity: this.dataItem.quantity,
        unitary_value: unitary_value_formated,
        total_item_value: this.dataItem.total_value_item,
      });

      this.form.subtotal += this.dataItem.total_value_item;

      this.closeModal();
    },

    removeItem(item) {
      this.form.subtotal -= item.total_item_value;

      this.form.purchase_items.splice(
        this.form.purchase_items.indexOf(item),
        1
      );
    },
  },
};
</script>