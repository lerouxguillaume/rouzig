<template>
    <div class="translations-form-container">
        <TanslationForm
                v-for="(translation, index) in translations"
                :key="index"
                :translation="translation"
                :on-remove-translation="removeTranslation"
        ></TanslationForm>
        <b-button variant="success" type="button" class="add-translation-button" @click="addTransaction">{{ $t('form.add-translation') }}</b-button>
    </div>
</template>

<script>
    import TanslationForm from "./Form/TanslationForm";
    import {Translation} from "../entities/Translation";

    export default {
        name: "TranslationsForm",
        components: {TanslationForm},
        props: {
            translations: {
                type: Array,
                required: true
            }
        },
        methods: {
            addTransaction() {
                this.translations.push(new Translation())
            },
            removeTranslation(element) {
                let index = this.translations.indexOf(element);

                if (index >= 0) {
                    this.translations.splice(index,1);
                }
            },
        }
    }
</script>

<style scoped>
    .translations-form-container {
        display: flex;
        flex-direction: column;
        margin-top: 25px;
    }
</style>