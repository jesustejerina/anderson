<template>
  <nav class="p-0 mt-6">
    <router-link :to="{ name: 'dashboard' }">Dashboard | </router-link>
    <router-link
      v-if="permisos.includes('menu_clientes')"
      :to="{ name: 'clientes' }"
      >&nbsp;Clientes |</router-link
    >
    <router-link
      v-if="permisos.includes('menu_registrar')"
      :to="{ name: 'register' }"
      >&nbsp;Registrar |</router-link
    >
    <router-link :to="{ name: 'home' }" @click="logout"
      >&nbsp;Logout</router-link
    >
  </nav>
</template>
<script setup>
import axios from "axios";
import { useStore } from "@/store/pinia";
const store = useStore();
var user_token = store.access_token;
const permisos = store.user.permissions;
const logout = async () => {
  let apiUrl = process.env.VUE_APP_URL_LOGOUT;
  let config = {
    headers: {
      Authorization: `Bearer ${user_token}`,
      "Content-Type": "multipart/form-data",
    },
  };
  await axios
    .post(apiUrl, {}, config)
    .then((response) => {
      let r = response.data;
      if (r.status == "OK") {
        store.access_token = "";
        store.user = "";
        store.Autenticado = false;
      }
    })
    .catch((error) => {
      let e = error.response.data;
      console.log("Logout error", e.message);
    });
};
</script>
