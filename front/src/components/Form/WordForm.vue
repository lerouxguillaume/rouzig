<template>
    <div class="word-form-container">
        <div class="row">
            <TextInput
                    id="word-original-input"
                    class-name="col-4"
                    :label="$t('form.original-word.word.label')"
                    v-model="translation.originalWord.text"
                    :placeholder="$t('form.original-word.word.placeholder')"
                    :error="$t(translation.originalWord.textError)"
                    :readonly="readonly"
            >
            </TextInput>
            <LanguageSelection
                    id="language-selection"
                    :origin="translation.originalWord.language"
                    :destination="translation.translatedWord.language"
                    @update:origin="value => translation.originalWord.language = value"
                    @update:destination="value => translation.translatedWord.language = value"
                    :readonly="readonly"
            ></LanguageSelection>
            <TextInput
                    id="word-translated-input"
                    class-name="col-4"
                    :label="$t('form.translated-word.word.label')"
                    v-model="translation.translatedWord.text"
                    :placeholder="$t('form.translated-word.word.placeholder')"
                    :error="$t(translation.originalWord.textError)"
                    :readonly="readonly"
            >
            </TextInput>
        </div>
        <div class="row">
            <TextAreaInput
                    id="translation-description"
                    class-name="col-12"
                    :label="$t('form.translated-word.description.label')"
                    :value="translation.translatedWord.description"
                    :readonly="readonly"
            >

            </TextAreaInput>
        </div>
        <div class="row">
            <SelectInput
                    id="option-input"
                    class-name="col-12"
                    :label="$t('form.original-word.type.label')"
                    v-model="translation.originalWord.wordType"
                    :options="typeOptions"
                    :error="$t(translation.originalWord.typeError)"
                    :readonly="readonly"
            >
            </SelectInput>
        </div>
    </div>
</template>

<script>
    import {WordTypes} from "../../utils/enum";
    import SelectInput from "./SelectInput";
    import TextInput from "./TextInput";
    import {Translation} from "../../entities/Translation";
    import TextAreaInput from "./TextAreaInput";
    import LanguageSelection from "./LanguageSelection";

    export default {
        name: "WordForm",
        components: {LanguageSelection, TextAreaInput, TextInput, SelectInput},
        props: {
            translation: {
                type: Translation,
                required: true
            },
            header: {
                type: String,
                required: false,
            },
            readonly: {
                type: Boolean,
                default: false
            }
        },
        computed : {
            typeOptions() {
                return WordTypes();
            }
        },
    }
</script>

<style scoped>
    .word-form-container {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .row {
        align-items: flex-end;
        justify-content: space-between;
    }
</style>