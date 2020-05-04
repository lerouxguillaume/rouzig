<template>
  <div id="app">
    <Header></Header>
    <div class="page-container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>

  import Header from "./components/Header/Header";

  export default {
    name: 'App',
    components: {
      Header
    }
  }

</script>

<style>
  #app {
    flex-direction: column;
  }
  .page-container {
    margin: 0 5%;
    justify-content: center;
  }
</style>
