<template>
    <div class="word-manager-container form">
        <b-form>
            <b-overlay :show="busy" rounded="sm" no-wrap></b-overlay>
            <div class="row">
                <TextInput
                        id="text-input"
                        :label="$t('form.word-name.label')"
                        v-model="word.word"
                        :placeholder="$t('form.word-name.placeholder')"
                        :error="$t(word.wordError)"
                >
                </TextInput>
                <SelectInput
                        id="option-input"
                        :label="$t('form.word-type.label')"
                        v-model="word.type"
                        :options="typeOptions"
                        :error="$t(word.typeError)"
                ></SelectInput>
                <SelectInput
                        id="option-input"
                        :label="$t('form.word-language.label')"
                        v-model="word.language"
                        :options="languageOptions"
                        :error="$t(word.languageError)"
                ></SelectInput>
            </div>
            <TranslationsForm :translations="word.translations" :language="word.language"></TranslationsForm>
            <div class="submit-button-container">
                <b-button variant="primary" type="submit" class="submit-button" @click="submit">{{ $t('form.submit') }}</b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
    import ApiService from "../services/api.service";
    import {Definition} from "../entities/Definition";
    import TranslationsForm from "../components/Form/TranslationsForm";
    import {Languages, Types} from "../utils/enum";
    import TextInput from "../components/Form/TextInput";
    import SelectInput from "../components/Form/SelectInput";
    import {Translation} from "../entities/Translation";

    export default {
        name: "AddTranslation",
        components: {SelectInput, TextInput, TranslationsForm},
        data() {
            return {
                'word' : new Definition(),
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
                return Types();
            }
        },
        mounted() {
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