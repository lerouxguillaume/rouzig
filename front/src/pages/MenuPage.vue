<template>
    <div class="menu-page-container">
        <LinkButton :to="{name: 'AddTranslation', params: {lang: $i18n.locale}}" class="button-create-translation-container" block>
            {{ $t('common.create-translation') }}
        </LinkButton>
        <WordsSubmittedManager></WordsSubmittedManager>
        <MissingWords></MissingWords>
        <UserTranslations v-if="loggedIn"></UserTranslations>
    </div>
</template>

<script>
    import WordsSubmittedManager from "../components/Tables/WordsSubmittedManager";
    import MissingWords from "../components/Tables/MissingWords";
    import LinkButton from "../components/Utils/LinkButton";
    import {mapGetters} from "vuex";
    import UserTranslations from "../components/Tables/UserTranslations";

    export default {
        name: "MenuPage",
        components: {UserTranslations, LinkButton, MissingWords, WordsSubmittedManager},
        data() {
            return {
            }
        },
        computed: {
            ...mapGetters('auth', [
                'loggedIn'
            ])
        }
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