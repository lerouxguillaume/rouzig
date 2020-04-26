<template>
    <div class="menu-container">

        <router-link :to="{name: 'wordManager'}">{{ $t('menu.create-word') }}</router-link>
        <div class="locale-changer">
            <select v-model="$i18n.locale">
                <option v-for="(lang, i) in langs" :key="`Lang${i}`" :value="lang">{{ lang }}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'NavigationMenu',
        data () {
            return { langs: ['br', 'fr'] }
        }
    }
</script>

<style scoped>
    .menu-container {
        display: flex;
        justify-content: end;
    }
    .locale-changer {
        display: flex;
        justify-content: end;
    }
</style>