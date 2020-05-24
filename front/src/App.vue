<template>
  <div id="app">
    <Header></Header>
    <div class="page-container">
      <router-view></router-view>
    </div>
    <Footer></Footer>
  </div>
</template>

<script>

  import Header from "./components/Header/Header";
  import Footer from "./components/Header/Footer";

  export default {
    name: 'App',
    components: {
      Footer,
      Header
    }
  }

</script>

<style>
  #app {
    flex-direction: column;
    min-height: 100%;
  }
  .page-container {
    margin: 0 5%;
    justify-content: center;
    flex: 1;
  }
</style>
