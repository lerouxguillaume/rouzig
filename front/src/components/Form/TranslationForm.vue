<template>
    <b-form>
        <div class="row">
            <PanelHeader v-model="page"></PanelHeader>
        </div>
        <div class="translation-form-container"  v-show="page === 1">
            <div class="row">
                <TextInput
                        id="word-original-input"
                        class-name="col-4"
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
                        :readonly="readonly"
                ></LanguageSelection>
                <TextInput
                        id="word-translated-input"
                        class-name="col-4"
                        :label="$t('form.word-name.label')"
                        v-model="translation.translatedWord.text"
                        :placehTextAreaInputolder="$t('form.word-name.placeholder')"
                        :error="$t(translation.originalWord.wordError)"
                        :readonly="readonly"
                >
                </TextInput>
            </div>
            <div class="row">
                <TextAreaInput
                        id="translation-description"
                        class-name="col-12"
                        :label="$t('form.word-name.label')"
                        :value="translation.translatedWord.description"
                        :readonly="readonly"
                >

                </TextAreaInput>
            </div>
            <div class="row">
                <SelectInput
                        id="option-input"
                        class-name="col-12"
                        :label="$t('form.word-type.label')"
                        v-model="translation.originalWord.wordType"
                        :options="typeOptions"
                        :error="$t(translation.originalWord.typeError)"
                        :readonly="readonly"
                >
                </SelectInput>
            </div>
            <!--            <SelectInput-->
            <!--                    id="option-input"-->
            <!--                    :label="$t('form.word-type.label')"-->
            <!--                    v-model="translation.originalWord.wordType"-->
            <!--                    :options="typeOptions"-->
            <!--                    :error="$t(translation.originalWord.typeError)"-->
            <!--                    :readonly="readonly"-->
            <!--            ></SelectInput>-->
            <!--        <WordForm :word="translation.originalWord"></WordForm>-->
            <!--        <WordForm :word="translation.translatedWord"></WordForm>-->
            <slot name="submit"></slot>
        </div>
        <div v-show="page === 2">
            <ExamplesForm :examples="translation.examples" :readonly="readonly"></ExamplesForm>
        </div>
    </b-form>
</template>
(
<script>
    import ExamplesForm from "./ExamplesForm";
    import {Translation} from "../../entities/Translation";
    import TextInput from "./TextInput";
    import SelectInput from "./SelectInput";
    import {Languages, WordTypes} from "../../utils/enum";
    import LanguageSelection from "./LanguageSelection";
    import TextAreaInput from "./TextAreaInput";
    import PanelHeader from "../Utils/PanelHeader";
    export default {
        name: "TranslationForm",
        // eslint-disable-next-line vue/no-unused-components
        components: {PanelHeader, TextAreaInput, LanguageSelection, SelectInput, TextInput, ExamplesForm},
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
        data: () => {
            return {
                page: 1,
            }
        },
        computed : {
            languageOptions() {
                return Languages();
            },
            typeOptions() {
                return WordTypes();
            }
        }
    }
</script>

<style scoped>
    .row {
        align-items: flex-end;
        justify-content: space-between;
    }
    .translation-form-container {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
</style>