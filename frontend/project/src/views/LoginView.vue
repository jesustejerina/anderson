<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img
        class="mx-auto h-20 w-auto"
        src="../assets/logo01.png"
        alt="Ing. Jesús Tejerina Rivera"
      />
      <h2
        class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
      >
        ACCESO
      </h2>
    </div>

    <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
      <div>
        <label
          for="email"
          class="block text-sm text-left font-medium leading-6 text-gray-900"
          >Email:</label
        >
        <div class="mt-2">
          <input
            id="email"
            name="email"
            type="email"
            autocomplete="email"
            required
            v-model="email"
            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          />
        </div>
      </div>

      <div class="mt-2">
        <div class="flex items-center justify-between">
          <label
            for="password"
            class="block text-sm font-medium leading-6 text-gray-900"
            >Contraseña:</label
          >
        </div>
        <div class="mt-2">
          <input
            id="password"
            name="password"
            type="password"
            autocomplete="current-password"
            required
            v-model="password"
            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          />
        </div>
      </div>

      <div class="mt-4 flex justify-center">
        <button
          type="submit"
          @click="login"
          class="w-32 rounded-md bg-indigo-500 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-800"
        >
          LOGIN
        </button>
      </div>
    </div>
  </div>
  <div>
    <vue3-snackbar top :duration="6000" shadow></vue3-snackbar>
  </div>
</template>
<script setup>
import axios from "axios";
import { useSnackbar } from "vue3-snackbar";
const snackbar = useSnackbar();
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "../store/pinia";
const store = useStore();
const router = useRouter();

const email = ref(null);
const password = ref(null);
/* eslint-disable-next-line */
const login = () => {
  let apiURL = process.env.VUE_APP_URL_LOGIN;
  let csrf = process.env.VUE_APP_URL_CSRF;
  const data = {
    email: email.value,
    password: password.value,
  };
  const config = {
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
      withCredentials: true,
    },
  };
  axios
    .get(csrf)
    /* eslint-disable-next-line */
    .then((response) => {
      axios
        .post(apiURL, data, config)
        .then((response) => {
          let r = response.data;
          if (r.status == "OK") {
            store.access_token = r.access_token;
            store.user = r.user;
            store.Autenticado = true;
            router.push({ name: "autenticados" });
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
          snackbar.add({
            type: "error",
            title: "ERROR2",
            text: r.message,
          });
        });
    })
    .catch((error) => {
      let r = error.response.data;
      //console.log(r);
      snackbar.add({
        type: "error",
        title: "ERROR3",
        text: r.message,
      });
    });
};
</script>
