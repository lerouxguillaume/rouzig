<template>
    <div class="header-container">
        <NavigationMenu></NavigationMenu>
        <div class="title-container">
            <router-link class="flex-shrink-1" :to="{name: 'homepage', params: {'lang': $i18n.locale}}"><img :src="logo"></router-link>
        </div>
    </div>
</template>

<script>
    import NavigationMenu from "./NavigationMenu";
    export default {
        name: "Header",
        components: {NavigationMenu},
        data: () => {
            return {
                logo: require('../../assets/logo.png')
            }
        }
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