<template>
    <div class="header-container">
        <NavigationMenu></NavigationMenu>
    </div>
</template>

<script>
    import NavigationMenu from "./NavigationMenu";
    export default {
        name: "Header",
        components: {NavigationMenu},
    }
</script>

<style scoped>
    .header-container{
        text-align: center;
        flex-direction: column;
    }
    .title-container {
        flex-direction: column;
    }
</style>