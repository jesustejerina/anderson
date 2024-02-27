<template>
  <div class="container mx-auto">
    <div class="mt-4 mb-3">
      <p class="text-2xl font-bold">CLIENTES</p>
    </div>
    <div class="max-w-lg mx-auto" v-if="mostrar_botones">
      <div class="inline-flex shadow-md rounded-md mb-5" role="group">
        <button
          type="button"
          class="rounded-l-lg border border-gray-200 bg-green-700 text-white text-sm font-bold px-4 py-2 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
          @click="agregarPago"
        >
          Agregar Pago
        </button>
        <button
          type="button"
          class="border-t border-b border-gray-200 bg-orange-200 text-sm font-bold px-4 py-2 text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
          @click="modificarPago"
        >
          Modificar Pago
        </button>
        <button
          type="button"
          class="rounded-r-md border border-gray-200 bg-red-700 text-white text-sm font-bold px-4 py-2 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
          @click="borrarPago"
        >
          Borrar Pago
        </button>
        <button
          type="button"
          class="rounded-r-md border border-gray-200 bg-red-700 text-white text-sm font-bold px-4 py-2 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
          @click="seleccionar_fila"
        >
          VER INDICE
        </button>
      </div>
    </div>
    <div class="flex justify-center">
      <DataTable
        ref="tabla_clientes"
        :data="clientes"
        :columns="columnas"
        :options="opciones"
        @select="filaSeleccionada()"
        @deselect="filaDeseleccionada()"
        class="display"
      >
      </DataTable>
    </div>
    <div v-if="hayPagos" class="mt-5">
      <div class="flex justify-center text-2xl font-bold">PAGOS</div>
      <div class="flex justify-center">
        <DataTable
          ref="tabla_pagos"
          :data="pagos"
          :columns="columnas_pagos"
          :options="opciones"
          @select="filaSeleccionadaPagos()"
          @deselect="filaDeseleccionadaPagos()"
          class="display"
        >
        </DataTable>
      </div>
    </div>
    <TransitionRoot as="template" :show="dialogAgregarPago">
      <Dialog as="div" class="relative z-10" @close="dialogAgregarPago = false">
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="ease-in duration-200"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
          />
        </TransitionChild>

        <div
          class="flex justify-center fixed inset-0 z-10 w-screen overflow-y-auto"
        >
          <div
            class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
          >
            <TransitionChild
              as="template"
              enter="ease-out duration-300"
              enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              enter-to="opacity-100 translate-y-0 sm:scale-100"
              leave="ease-in duration-200"
              leave-from="opacity-100 translate-y-0 sm:scale-100"
              leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
              <DialogPanel
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
              >
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                  <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                      <DialogTitle
                        as="h3"
                        class="text-base text-gray-700 font-semibold leading-6"
                        >AGREGAR PAGO</DialogTitle
                      >
                      <div class="mt-2">
                        <div>
                          <label
                            for="forma_pago"
                            class="block mb-1 text-sm text-left font-medium text-gray-900 dark:text-gray-400"
                            >Forma de Pago:</label
                          >
                          <select
                            id="forma_pago"
                            v-model="pago.forma"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                          >
                            <option value="efectivo">Efectivo</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="yape">Yape</option>
                          </select>
                        </div>
                        <div class="mt-3">
                          <label
                            for="detalle_pago"
                            class="block mb-1 text-sm text-left font-medium text-gray-900 dark:text-gray-400"
                            >Detalle:</label
                          >
                          <input
                            id="detalle_pago"
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            v-model="pago.detalle"
                          />
                        </div>
                        <div class="mt-3">
                          <label
                            for="monto_pago"
                            class="block mb-1 text-sm text-left font-medium text-gray-900 dark:text-gray-400"
                            >Monto:</label
                          >
                          <input
                            id="monto_pago"
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            v-model="pago.monto"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                >
                  <button
                    type="button"
                    class="inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-200 sm:ml-3 sm:w-auto"
                    @click="dialogAgregarPago = false"
                  >
                    Cancelar
                  </button>
                  <button
                    type="button"
                    class="mt-3 inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-blue-800 sm:mt-0 sm:w-auto"
                    @click="guardarPago"
                  >
                    Guardar
                  </button>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
    <div>
      <vue3-snackbar top :duration="6000" shadow>
        <template #message-content="{ title, text }">
          <strong v-text="title"></strong>
          <p v-text="text" v-html="text"></p>
        </template>
      </vue3-snackbar>
    </div>
  </div>
</template>
<script setup>
import { useSnackbar } from "vue3-snackbar";

import axios from "axios";
import { onMounted, ref, reactive } from "vue";
import { useStore } from "../store/pinia";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import "datatables.net-select";
import "datatables.net-responsive";
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";

DataTable.use(DataTablesCore);
const snackbar = useSnackbar();
const columnas = [
  { data: "id", title: "ID" },
  { data: "nombres", title: "Nombres", width: "150px" },
  { data: "apellidos", title: "Apellidos", width: "150px" },
  { data: "email", title: "Email", width: "100px" },
  { data: "total_pagos", title: "Total Pagos", width: "120px" },
];

const columnas_pagos = [
  { data: "id", title: "ID" },
  { data: "forma_pago", title: "Forma", width: "150px" },
  { data: "detalle", title: "Detalle", width: "200px" },
  { data: "monto", title: "Monto", width: "100px" },
];

const opciones = {
  responsive: true,
  select: true,
  bPaginate: false,
  bInfo: false,
  bSelect: true,
  bFilter: false,
  scrollCollapse: true,
  scrollY: "400px",
  scrollX: "600px",
};

const tabla_clientes = ref();
const pago = reactive({
  forma: "efectivo",
  detalle: "",
  monto: "",
  cliente_id: 0,
});

const filaSeleccionada = () => {
  let selectedRows = tabla_clientes.value.dt.rows({ selected: true }).data();
  let ids = selectedRows.map((row) => row.id);
  if (ids[0] > 0) {
    mostrar_botones.value = true;
    pago.cliente_id = ids[0];
    damePagos();
  }
};

const filaDeseleccionada = () => {
  let deselectedRows = tabla_clientes.value.dt.rows({ selected: false }).data();
  if (deselectedRows) {
    let ids = deselectedRows.data().map((row) => row.id);
    if (ids.length > 0) {
      mostrar_botones.value = false;
      pago.cliente_id = 0;
      hayPagos.value = false;
    }
  }
};

const filaSeleccionadaPagos = () => {
  /*
    const selectedRows = tabla_pagos.value.dt.rows({ selected: true }).data();
  const ids = selectedRows.map((row) => row.id);
  if (ids[0] > 0) {
    mostrar_botones.value = true;
    pago.cliente_id = ids[0];
  }
  */
};

const filaDeseleccionadaPagos = () => {
  /*
    const deselectedRows = tabla_pagos.value.dt.rows({ selected: false }).data();
  if (deselectedRows) {
    const ids = deselectedRows.data().map((row) => row.id);
    if (ids.length > 0) {
      mostrar_botones.value = false;
      pago.cliente_id = 0;
    }
  }
  */
};

/* NO FUNCIONA
const seleccionar_fila = () => {
  
  let dt = tabla_clientes.value.dt;
  let row_indexes = dt.rows({ selected: true }).indexes().toArray();
  console.log("row_indexes: ", row_indexes);
  let fs = dt.rows({ selected: true }).data();
  if (fs) {
    fs.map((row, index) => {
      console.log("* fs.map index: ", index);
      if (row.id == pago.cliente_id) {
        dt.row(row_indexes[index]).select();
        console.log("  *row_indexes[index]: ", row_indexes[index]);
        console.log("  *row.id: ", row.id);
      }
    });
  }
};
*/

const clientes = ref(null);
const store = useStore();
const mostrar_botones = ref(false);

const dameClientes = () => {
  let user_token = store.access_token;
  let apiUrl = process.env.VUE_APP_URL_DAME_CLIENTES;
  let config = {
    headers: {
      Authorization: `Bearer ${user_token}`,
      "Content-Type": "application/json",
      Accept: "application/json",
    },
  };
  axios
    .get(apiUrl, config)
    .then((response) => {
      let r = response.data;
      clientes.value = r.clientes;
    })
    .catch((error) => {
      console.log(error);
    });
};

const dialogAgregarPago = ref(false);
const agregarPago = () => {
  pago.forma = "efectivo";
  pago.detalle = "";
  pago.monto = "";
  if (pago.cliente_id > 0) {
    dialogAgregarPago.value = true;
  } else {
    snackbar.add({
      type: "warning",
      title: "CUIDADO!",
      text: "Debe seleccionar un cliente",
    });
  }
};

const guardarPago = () => {
  let user_token = store.access_token;
  let apiUrl = process.env.VUE_APP_URL_AGREGAR_PAGO;
  const config = {
    headers: {
      Authorization: `Bearer ${user_token}`,
      "Content-Type": "application/json",
      Accept: "application/json",
    },
  };
  axios
    .post(apiUrl, pago, config)
    .then((response) => {
      let r = response.data;
      if (r.status == "OK") {
        snackbar.add({
          type: "success",
          title: "AGREGAR PAGO",
          text: r.message,
        });
        dialogAgregarPago.value = false;
        dameClientes();
        damePagos();
        pago.cliente_id = 0;
      } else {
        snackbar.add({
          type: "error",
          title: "ERROR1",
          text: r.message,
        });
      }
    })
    .catch((error) => {
      let r = error.response.data;
      if (r.status == "ERROR") {
        snackbar.add({
          type: "error",
          title: "ERROR: " + r.message,
          text: r.error,
        });
      }
      if (r.status == "ERROR_VALIDACION") {
        let errors = r.errors;
        let errores = "";
        Object.keys(errors).forEach((key) => {
          errores += errors[key][0] + "<br>";
        });
        snackbar.add({
          type: "error",
          title: "FALTAN DATOS: ",
          text: errores,
        });
      }
      if (r.exception != null) {
        snackbar.add({
          type: "error",
          title: "ERROR: " + r.message,
          text: r.error,
        });
      }
    });
};

const pagos = ref(null);
const hayPagos = ref(false);

const damePagos = () => {
  let user_token = store.access_token;
  let apiUrl = process.env.VUE_APP_URL_DAME_PAGOS;
  let config = {
    headers: {
      Authorization: `Bearer ${user_token}`,
      "Content-Type": "application/json",
      Accept: "application/json",
    },
  };
  axios
    .get(apiUrl + "/" + pago.cliente_id, config)
    .then((response) => {
      let r = response.data;
      if (r.status == "OK") {
        pagos.value = r.pagos;
        hayPagos.value = true;
      } else {
        hayPagos.value = false;
        snackbar.add({
          type: "info",
          title: "ATENCIÓN",
          text: r.message,
        });
      }
    })
    .catch((error) => {
      let r = error.response.data;
      hayPagos.value = false;
      if (r.status == "ERROR") {
        snackbar.add({
          type: "error",
          title: "ERROR: " + r.message,
          text: r.error,
        });
      }
      if (r.exception != null) {
        snackbar.add({
          type: "error",
          title: "ERROR: " + r.message,
          text: r.error,
        });
      }
    });
};

const borrarPago = () => {
  dameClientes();
};

onMounted(() => {
  dameClientes();
});
</script>
<style scoped>
@import "datatables.net-dt";
</style>
