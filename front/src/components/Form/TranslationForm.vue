<template>
    <div class="translation-form-container">
        <b-form>
        <div class="row">
            <TextInput
                    id="word-original-input"
                    :label="$t('form.word-name.label')"
                    v-model="translation.originalWord.text"
                    :placeholder="$t('form.word-name.placeholder')"
                    :error="$t(translation.originalWord.wordError)"
                    :readonly="readonly"
            >
            </TextInput>
            <LanguageSelection
                    id="language-selection"
                    :origin="translation.originalWord.language"
                    :destination="translation.translatedWord.language"
                    @update:origin="value => translation.originalWord.language = value"
                    @update:destination="value => translation.translatedWord.language = value"
            ></LanguageSelection>
            <TextInput
                    id="word-translated-input"
                    :label="$t('form.word-name.label')"
                    v-model="translation.translatedWord.text"
                    :placeholder="$t('form.word-name.placeholder')"
                    :error="$t(translation.originalWord.wordError)"
                    :readonly="readonly"
            >
            </TextInput>

<!--            <SelectInput-->
<!--                    id="option-input"-->
<!--                    :label="$t('form.word-type.label')"-->
<!--                    v-model="translation.originalWord.wordType"-->
<!--                    :options="typeOptions"-->
<!--                    :error="$t(translation.originalWord.typeError)"-->
<!--                    :readonly="readonly"-->
<!--            ></SelectInput>-->
        </div>
        <button @click="show">show</button>
<!--        <WordForm :word="translation.originalWord"></WordForm>-->
<!--        <WordForm :word="translation.translatedWord"></WordForm>-->
<!--        <ExamplesForm :examples="translation.examples" :readonly="readonly"></ExamplesForm>-->
        <slot name="submit"></slot>

        </b-form>
    </div>
</template>

<script>
    import ExamplesForm from "./ExamplesForm";
    import {Translation} from "../../entities/Translation";
    import TextInput from "./TextInput";
    import SelectInput from "./SelectInput";
    import {Languages, WordTypes} from "../../utils/enum";
    import LanguageSelection from "./LanguageSelection";
    export default {
        name: "TranslationForm",
        // eslint-disable-next-line vue/no-unused-components
        components: {LanguageSelection, SelectInput, TextInput, ExamplesForm},
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
        methods: {
            show() {
                console.log(this.translation.originalWord.language)
                console.log(this.translation.translatedWord.language)
            }
        }
    }
</script>

<style scoped>
    .translation-form-container {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
</style>