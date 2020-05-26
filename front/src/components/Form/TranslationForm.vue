<template>
    <div class="translation-form-container">
        <b-form>

        </b-form>
        <TextInput
                id="text-input"
                :label="$t('form.word-name.label')"
                v-model="translation.originalWord.text"
                :placeholder="$t('form.word-name.placeholder')"
                :error="$t(translation.originalWord.wordError)"
                :readonly="readonly"
        >
        </TextInput>
        <SelectInput
                id="option-input"
                :label="$t('form.word-type.label')"
                v-model="translation.originalWord.wordType"
                :options="typeOptions"
                :error="$t(translation.originalWord.typeError)"
                :readonly="readonly"
        ></SelectInput>
<!--        <WordForm :word="translation.originalWord"></WordForm>-->
<!--        <WordForm :word="translation.translatedWord"></WordForm>-->
        <ExamplesForm :examples="translation.examples" :readonly="readonly"></ExamplesForm>
        <slot name="submtrueit"></slot>
    </div>
</template>

<script>
    import ExamplesForm from "./ExamplesForm";
    import {Translation} from "../../entities/Translation";
    import TextInput from "./TextInput";
    import SelectInput from "./SelectInput";
    import {Languages, WordTypes} from "../../utils/enum";
    export default {
        name: "TranslationForm",
        components: {SelectInput, TextInput, ExamplesForm},
        props: {
            translation: {
                required: true,
                type: Translation
            },
            readonly: {
                type: Boolean,
                default: false
            }
        },
        computed : {
            languageOptions() {
                return Languages();
            },
            typeOptions() {
                return WordTypes();
            }
        },
    }
</script>

<style scoped>
    .translation-form-container {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
</style>