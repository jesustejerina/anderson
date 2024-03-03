<template>
  <div class="container mx-auto">
    <h1>DASHBOARD</h1>
    <p>
      Bienvenido <strong>{{ usuario }}</strong>
    </p>
    <p>
      <italic>{{ rol }}</italic>
    </p>
  </div>
</template>
<script setup>
import { ref } from "vue";
import { useStore } from "../store/pinia";
const store = useStore();
const usuario = ref(store.user.name);
const rol = ref(store.user.role);
</script>
