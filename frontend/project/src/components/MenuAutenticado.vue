<template>
  <nav class="m-0 p-0">
    <router-link :to="{ name: 'dashboard' }">Dashboard</router-link> |
    <router-link :to="{ name: 'clientes' }">Clientes</router-link> |
    <router-link :to="{ name: 'pagos' }">Pagos</router-link> |
    <router-link :to="{ name: 'register' }">Registrar</router-link> |
    <router-link :to="{ name: 'home' }" @click="logout">Logout</router-link>
  </nav>
</template>
<script setup>
import axios from "axios";
import { useStore } from "@/store/pinia";
const store = useStore();
var user_token = store.access_token;
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
        console.log("Logout OK");
      }
    })
    .catch((error) => {
      let e = error.response.data;
      console.log("Logout error", e.message);
    });
};
</script>
