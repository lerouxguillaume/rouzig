<template>
    <div class="header-container">
        <NavigationMenu></NavigationMenu>
        <router-link :to="{name: 'homepage'}"><h1>{{ $t('header.title') }}</h1></router-link>

        <h2>{{ $t('header.sub-title') }}</h2>
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
    }
</style>