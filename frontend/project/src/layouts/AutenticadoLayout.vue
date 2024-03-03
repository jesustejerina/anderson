<template>
  <div class="flex flex-col h-screen">
    <header class="fixed top-0 w-full">
      <AppHeader />
    </header>
    <main class="mt-3 mb-2">
      <router-view />
    </main>
    <footer class="fixed bottom-0 w-full">
      <AppFooter />
    </footer>
  </div>
</template>

<script setup>
import AppHeader from "../components/AppHeader.vue";
import AppFooter from "../components/AppFooter.vue";
</script>
