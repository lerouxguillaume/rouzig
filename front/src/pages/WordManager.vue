<template>
    <div class="word-manager-container form">
        <div class="row">
            <div class="input" role="group">
                <label for="text-input">{{ $t('form.word-name.label') }}:</label>
                <b-input id="text-input" v-model="word.text" :placeholder="$t('form.word-name.placeholder')" @change="search" trim></b-input>
            </div>
            <div class="input">
                <label for="option-input">{{ $t('form.type.label') }}</label>
                <b-form-select  id="option-input" v-model="word.type" :options="typeOptions" trim></b-form-select>
            </div>
            <div class="input">
                <label for="language-input">{{ $t('form.word-language.label') }} : </label>
                <b-form-select id="language-input" v-model="word.language" :options="languageOptions" trim></b-form-select>
            </div>
        </div>
        <TranslationsForm :translations="word.translations" :language="word.language"></TranslationsForm>
        <div class="submit-button-container">
            <b-button variant="primary" type="submit" class="submit-button" @click="submit">{{ $t('form.submit') }}</b-button>
        </div>
    </div>
</template>

<script>
    import ApiService from "../../services/api.service";
    import {Definition} from "../entities/Definition";
    import TranslationsForm from "../components/TranslationsForm";
    import {Languages, Types} from "../utils/enum";

    export default {
        name: "WordManager",
        components: {TranslationsForm},
        data() {
            return {
                'word' : new Definition(),
            }
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
            search() {
                let params = {
                    'headers' : {
                        'Accept' : 'application/vnd.api+json'
                    },
                    'params' : {
                        'text': this.word.text
                    }
                };

                ApiService.get(process.env.VUE_APP_API_URL + 'words', params)
                    .then((response) => {
                        let data = response.data.data.shift();
                        if (typeof data !== 'undefined') {
                            let newDefinition = new Definition();
                            newDefinition.load(data);
                            this.word = newDefinition;
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    })
            },
            submit() {
                let options = {
                    headers: { 'Content-Type': 'application/json' },
                };
                ApiService.post(process.env.VUE_APP_API_URL + 'words', JSON.stringify(this.word, (key, value) => {
                    if (value !== null) return value
                }) ,options)
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