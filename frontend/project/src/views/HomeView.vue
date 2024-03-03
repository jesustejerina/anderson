<template>
  <div>
    <div class="flex justify-center mt-5">
      <img
        class="w-20"
        alt="Ing. Jesús Tejerina Rivera"
        src="../assets/logo01.png"
      />
    </div>
    <div class="mt-3">
      <HelloWorld msg="Sistema Pago Clientes" />
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from "@/components/HelloWorld.vue";

export default {
  name: "HomeView",
  components: {
    HelloWorld,
  },
};
</script>
