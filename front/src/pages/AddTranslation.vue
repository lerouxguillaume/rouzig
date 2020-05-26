<template>
    <div class="word-manager-container">
        <b-form class="flex flex-grow-1">
            <b-overlay :show="busy" rounded="sm" no-wrap></b-overlay>
            <TranslationForm :translation="translation">
                <template v-slot:submit>
                    <div class="submit-button-container">
                        <b-button variant="primary" type="submit" class="submit-button" @click="submit">{{ $t('form.submit') }}</b-button>
                    </div>
                </template>
            </TranslationForm>
        </b-form>
    </div>
</template>

<script>
    import ApiService from "../services/api.service";
    import {Translation} from "../entities/Translation";
    import TranslationForm from "../components/Form/TranslationForm";

    export default {
        name: "AddTranslation",
        components: {TranslationForm},
        data() {
            return {
                'translation' : new Translation(),
                'busy': false
            }
        },
        mounted() {
            if (this.$route.params.word) {
                this.translation.originalWord.text = this.$route.params.word;
            }
        },
        methods: {
            submit() {
                this.busy = true;
                let options = {
                    headers: { 'Content-Type': 'application/json' },
                };
                ApiService.post(process.env.VUE_APP_API_URL + 'translations', JSON.stringify(this.translation.post(), (key, value) => {
                    if (value !== null) return value
                }, options) ,options)
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