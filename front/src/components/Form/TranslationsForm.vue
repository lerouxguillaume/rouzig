<template>
    <div class="translations-form-container">
        <TanslationForm
                v-for="(translation, index) in translations"
                :key="index"
                :translation="translation"
                :on-remove-translation="removeTranslation"
                :language="language"
        ></TanslationForm>
        <b-button variant="success" type="button" class="add-translation-button" @click="addTranslation">{{ $t('form.add-translation') }}</b-button>
    </div>
</template>

<script>
    import TanslationForm from "./TanslationForm";
    import {Translation as TranslationEntity} from "../../entities/Translation";
    import {Translation} from "../../utils/enum";

    export default {
        name: "TranslationsForm",
        components: {TanslationForm},
        props: {
            translations: {
                type: Array,
                required: true
            },
            language: {
                type: String
            }
        },
        methods: {
            addTranslation() {
                this.translations.push(new TranslationEntity(Translation[this.language]))
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