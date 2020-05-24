<template>
    <b-card

            header-bg-variant="primary"
            border-variant="primary"
            :header="header"
    >
        <div class="row">
            <TextInput
                    id="text-input"
                    :label="$t('form.word-name.label')"
                    v-model="word.text"
                    :placeholder="$t('form.word-name.placeholder')"
                    :error="$t(word.wordError)"
            >
            </TextInput>
            <SelectInput
                    id="option-input"
                    :label="$t('form.word-type.label')"
                    v-model="word.wordType"
                    :options="typeOptions"
                    :error="$t(word.typeError)"
            ></SelectInput>
            <SelectInput
                    id="option-input"
                    :label="$t('form.word-language.label')"
                    v-model="word.language"
                    :options="languageOptions"
                    :error="$t(word.languageError)"
            ></SelectInput>
        </div>
    </b-card>
</template>

<script>
    import {Languages, WordTypes} from "../../utils/enum";
    import {Word} from "../../entities/Word";
    import SelectInput from "./SelectInput";
    import TextInput from "./TextInput";

    export default {
        name: "WordForm",
        components: {TextInput, SelectInput},
        props: {
            word: {
                type: Word,
                required: true
            },
            header: {
                type: String,
                required: false,
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
    .translation-container {
        flex-direction: column;
        flex-grow: 1;
    }
    .delete-button-container {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }
</style>