<template>
    <b-card
            class="card-content-container"
            :header="$i18n.t($router.currentRoute.meta.title)"
    >
            <router-view></router-view>
    </b-card>
</template>

<script>
    export default {
        name: "NestedRouterView",
    }
</script>

<style scoped>
    .card-content-container {
        margin: 2% 5%;
    }
</style>