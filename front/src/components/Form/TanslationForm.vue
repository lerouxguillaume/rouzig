<template>
    <div>
        <div class="row">
            <div class="input" role="group">
                <label for="text-input">Name:</label>
                <input id="text-input" v-model="translation.text" placeholder="Enter your name">
            </div>
            <div class="input">
                <label for="language-input">Description:</label>
                <input id="description-input" v-model="translation.description" placeholder="Enter your name">
            </div>
            <div class="input">
                <label for="language-input">Description:</label>
                <b-form-select id="language-input" v-model="translation.language" :options="languageOptions" trim></b-form-select>
            </div>
            <div class="input">
                <label for="option-input">Name:</label>
                <b-form-select  id="option-input" v-model="translation.type" :options="typeOptions" trim></b-form-select>
            </div>
        </div>
    </div>
</template>

<script>
    import {Translation} from "../../entities/Translation";

    export default {
        name: "TanslationForm",
        props: {
            translation: Translation
        },
        computed : {
            languageOptions() {
                return [
                    {value: null, text: 'Please select an option'},
                    {value: 'br', text: this.$t('common.breton')},
                    {value: 'fr', text: this.$t('common.french')},
                ]
            },
            typeOptions() {
                return [
                    {value: null, text: 'Please select an option'},
                    {value: 'verb', text: this.$t('common.breton')},
                    {value: 'noun', text: this.$t('common.french')},
                    {value: 'adjective', text: this.$t('common.french')},
                ]
            }
        }
    }
</script>

<style scoped>

</style>