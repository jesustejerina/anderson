<template>
  <div>
    <h1 class="text-2xl font-bold">{{ msg }}</h1>
    <p>Ing. Jesús Tejerina Rivera</p>
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
