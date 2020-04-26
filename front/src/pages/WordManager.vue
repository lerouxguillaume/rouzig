<template>
    <div class="word-manager-container">
        <div class="row">
            <div class="input" role="group">
                <label for="text-input">Name:</label>
                <input id="text-input" v-model="word.text" placeholder="Enter your name" @change="search">
            </div>
            <div class="input">
                <label for="language-input">Name:</label>
                <b-form-select id="language-input" v-model="word.language" :options="languageOptions" trim></b-form-select>
            </div>
            <div class="input">
                <label for="option-input">Name:</label>
                <b-form-select  id="option-input" v-model="word.type" :options="typeOptions" trim></b-form-select>
            </div>
        </div>
        <div class="transactions-form-container">
            <TanslationForm
                    v-for="(translation, index) in word.translations"
                    :key="index"
                    :translation="translation"
            ></TanslationForm>
            <button type="button" @click="addTransaction"></button>
        </div>

        <button type="submit" @click="submit"></button>
    </div>
</template>

<script>
    import ApiService from "../../services/api.service";
    import {Definition} from "../entities/Definition";
    import TanslationForm from "../components/Form/TanslationForm";
    import {Translation} from "../entities/Translation";

    export default {
        name: "WordManager",
        components: {TanslationForm},
        data() {
            return {
                'word' : new Definition(),
            }
        },
        computed : {
            languageOptions() {
                return [
                    { value: null, text: 'Please select an option' },
                    { value: 'br', text: this.$t('common.breton') },
                    { value: 'fr', text: this.$t('common.french') },
                ]
            },
            typeOptions() {
                return [
                    { value: null, text: 'Please select an option' },
                    { value: 'verb', text: this.$t('common.breton') },
                    { value: 'noun', text: this.$t('common.french') },
                    { value: 'adjective', text: this.$t('common.french') },
                ]
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
            addTransaction() {
                this.word.translations.push(new Translation())
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
    }
    .row {
        display: flex;
        flex-grow: 1;
    }
    .input {
        justify-content: center;
        display: flex;
        flex-grow: 1;
    }
</style>