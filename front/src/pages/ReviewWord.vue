<template>
    <div class="word-manager-container form">
        <div class="row">
            <div class="input" role="group">
                <label for="text-input">{{ $t('form.word-name.label') }}:</label>
                <b-input id="text-input" v-model="translation.text" :placeholder="$t('form.word-name.placeholder')" :disabled="true" trim></b-input>
            </div>
            <div class="input">
                <label for="option-input">{{ $t('form.word-type.label') }}</label>
                <b-form-select  id="option-input" v-model="translation.type" :options="typeOptions" trim></b-form-select>
            </div>
            <div class="input">
                <label for="language-input">{{ $t('form.word-language.label') }} : </label>
                <b-form-select id="language-input" v-model="translation.language" :options="languageOptions" trim></b-form-select>
            </div>
        </div>
        <TranslationsForm :translations="translation.translations" :language="translation.language"></TranslationsForm>
        <div class="submit-button-container">
            <b-button variant="danger" type="submit" class="submit-button" @click="deleteTranslation">{{ $t('review.delete') }}</b-button>
            <b-button variant="primary" type="submit" class="submit-button" @click="updateTranslation">{{ $t('review.update') }}</b-button>
            <b-button variant="success" type="submit" class="submit-button" @click="validateTranslation">{{ $t('review.valid') }}</b-button>
        </div>
    </div>
</template>

<script>
    import ApiService from "../../services/api.service";
    import {Definition} from "../entities/Definition";
    import TranslationsForm from "../components/Form/TranslationsForm";
    import {Languages, Types} from "../utils/enum";

    export default {
        name: "ReviewWord",
        components: {TranslationsForm},
        data() {
            return {
                'translation' : new Definition(),
            }
        },
        mounted() {
            let params = {
                'headers' : {
                    'Accept' : 'application/vnd.api+json'
                },
            };

            ApiService.get(process.env.VUE_APP_API_URL + 'words/'+this.$route.params.id, params)
                .then((response) => {
                    let data = response.data.data;
                    if (typeof data !== 'undefined') {
                        let newDefinition = new Definition();
                        newDefinition.load(data);
                        this.translation = newDefinition;
                    }
                })
                .catch(function (error) {
                    console.error(error);
                })
        },
        computed : {
            languageOptions() {
                return Languages();
            },
            typeOptions() {
                return Types();
            }
        },
        methods: {
            updateTranslation() {
                let options = {
                    headers: { 'Content-Type': 'application/merge-patch+json' },
                };
                ApiService.patch(process.env.VUE_APP_API_URL + 'words/'+this.$route.params.id , JSON.stringify(this.translation.patch(), (key, value) => {
                    if (value !== null) return value
                }) ,options)
                    .then((response) => {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.error(error);
                    })

            },
            deleteTranslation() {
                let options = {
                    headers: { 'Content-Type': 'application/json' },
                };
                ApiService.delete(process.env.VUE_APP_API_URL + 'words/'+this.$route.params.id ,options)
                    .then((response) => {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.error(error);
                    })

            },
            validateTranslation() {
                let options = {
                    headers: { 'Content-Type': 'application/json' },
                };
                ApiService.post(process.env.VUE_APP_API_URL + 'words/validate/'+this.$route.params.id ,options)
                    .then((response) => {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.error(error);
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