<template>
    <div class="menu-page-container">
        <LinkButton :to="{name: 'AddTranslation'}" class="button-create-translation-container" block>
            {{ $t('common.create-translation') }}
        </LinkButton>
        <WordsSubmittedManager></WordsSubmittedManager>
        <MissingWords></MissingWords>
    </div>
</template>

<script>
    import WordsSubmittedManager from "../components/Tables/WordsSubmittedManager";
    import MissingWords from "../components/Tables/MissingWords";
    import LinkButton from "../components/Utils/LinkButton";

    export default {
        name: "MenuPage",
        components: {LinkButton, MissingWords, WordsSubmittedManager},
        data() {
            return {
            }
        },
    }
</script>

<style scoped>
    .menu-page-container {
        flex-direction: column;
        justify-content: center;
        align-items: center;
        flex-grow: 1;
    }
    .button-create-translation-container {
        justify-content: center;
        flex-grow: 1;
        margin: 16px 0;
    }
</style>