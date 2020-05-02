<template>
    <div class="menu-page-container form">
        <WordsNotFound></WordsNotFound>
        <b-button variant="success">
            <router-link :to="{name: 'AddTranslation'}">{{ $t('menu.create-word') }}</router-link>
        </b-button>
        <WordsSubmittedManager></WordsSubmittedManager>
    </div>
</template>

<script>
    import WordsNotFound from "../components/WordsNotFound";
    import WordsSubmittedManager from "../components/WordsSubmittedManager";

    export default {
        name: "MenuPage",
        components: {WordsNotFound, WordsSubmittedManager},
        data() {
            return {
            }
        },
    }
</script>

<style scoped>
    .word-manager-container {
        display: flex;
        flex-direction: column;
        margin: 0 5%;
    }
    .submit-button-container {
        display: flex;
        flex-grow: 1;
        margin: 25px 0;
     }
    .submit-button {
        width: 100%;
    }

</style>