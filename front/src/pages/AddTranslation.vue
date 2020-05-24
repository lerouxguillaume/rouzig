<template>
    <div class="word-manager-container form">
        <b-form>
            <b-overlay :show="busy" rounded="sm" no-wrap></b-overlay>
            <WordForm :word="translation.originalWord"></WordForm>
            <WordForm :word="translation.translatedWord"></WordForm>
            <ExamplesForm :examples="translation.examples"></ExamplesForm>
            <div class="submit-button-container">
                <b-button variant="primary" type="submit" class="submit-button" @click="submit">{{ $t('form.submit') }}</b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
    import ApiService from "../services/api.service";
    import {Languages, WordTypes} from "../utils/enum";
    import {Translation} from "../entities/Translation";
    import WordForm from "../components/Form/WordForm";
    import ExamplesForm from "../components/Form/ExamplesForm";

    export default {
        name: "AddTranslation",
        components: {ExamplesForm, WordForm},
        data() {
            return {
                'translation' : new Translation(),
                'busy': false
            }
        },
        computed : {
            text() {
                return this.word.word;
            },
            languageOptions() {
                return Languages();
            },
            typeOptions() {
                return WordTypes();
            }
        },
        mounted() {
            if (this.$route.params.word) {
                this.word.word = this.$route.params.word;
            }

            this.word.translations.push(new Translation())
        },
        methods: {
            submit() {
                this.busy = true;
                let options = {
                    headers: { 'Content-Type': 'application/json' },
                };
                ApiService.post(process.env.VUE_APP_API_URL + 'words', JSON.stringify(this.word.post(), (key, value) => {
                    if (value !== null) return value
                }) ,options)
                    .then(() => {
                        this.$router.push({ name:'MenuPage' })
                    })
                    .catch((error) => {
                        let response = error.response;
                        if (response.status === 400) {
                            this.word.loadErrors(response.data)
                        }
                        this.busy = false;
                    })
            }
        }
    }
</script>

<style scoped>
    .word-manager-container {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
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