<template>
  <div>
    <div class="flex justify-center">
      <img
        class="w-20"
        alt="Ing. Jesús Tejerina Rivera"
        src="../assets/logo01.png"
      />
    </div>
    <div>
      <HelloWorld msg="Prueba para Anderson Ramos" />
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
