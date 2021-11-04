<template>
<Login />
</template>

<script>

import Login from './Login.vue';

export default {


  name: 'App',
  components: {
    Login
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  height: 100vh;
}

html, body{
  margin: 0px !important;
}

</style>
