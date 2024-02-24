<template>
  <div>
    <h1 class="text-2xl font-bold">{{ msg }}</h1>
    <p>FrontEnd y BackEnd</p>
    <h3 class="mt-3">Con agrado...</h3>
  </div>
</template>

<script>
export default {
  name: "HelloWorld",
  props: {
    msg: String,
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
a {
  color: #42b983;
}
</style>
