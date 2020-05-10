<template>
    <b-card

            header-bg-variant="primary"
            border-variant="primary"
            :header="$t('common.translation') + ' ' + this.translationId "
    >
        <div class="translation-container">
            <div class="row">
                <TextInput
                        id="translation-input"
                        :label="$t('form.translation-name.label')"
                        v-model="translation.word"
                        :placeholder="$t('form.translation-name.placeholder')"
                        :error="$t(translation.wordError)"
                ></TextInput>
                <SelectInput
                        :id="'translation-type-' +  this.translationId"
                        :label="$t('form.translation-type.label')"
                        v-model="translation.wordType"
                        :options="typeOptions"
                        :error="$t(translation.wordTypeError)"
                ></SelectInput>
            </div>
            <div class="row">
                <TextAreaInput
                        :id="'description-textarea-' + this.translationId"
                        :label="$t('form.translation-description.label')"
                        v-model="translation.description"
                        :placeholder="$t('form.translation-description.placeholder')"
                        :error="$t(translation.descriptionError)"
                ></TextAreaInput>
            </div>
            <ExemplesForm :examples="translation.examples" :language="language">
            </ExemplesForm>
            <div class="delete-button-container">
                <b-button variant="success" type="button" class="add-exemple-button" @click="addExample">{{ $t('form.add-example') }}</b-button>
                <b-button type="button" variant="danger" class="delete-translation-button" @click="onRemoveTranslation(translation)">{{ $t('form.delete-translation') }}</b-button>
            </div>
        </div>
    </b-card>
</template>

<script>
    import {Translation as TranslationEntity} from "../../entities/Translation";
    import ExemplesForm from "./ExamplesForm";
    import {Example} from "../../entities/Example";
    import TextInput from "./TextInput";
    import SelectInput from "./SelectInput";
    import TextAreaInput from "./TextAreaInput";
    import {Languages, Translation, WordTypes} from "../../utils/enum";

    export default {
        name: "TanslationForm",
        components: {TextAreaInput, SelectInput, TextInput, ExemplesForm},
        props: {
            translation: TranslationEntity,
            onRemoveTranslation: {
                type: Function,
                required: true
            },
            language: {
                type: String
            }
        },
        watch: {
            language: function (newVal) {
                this.translation.language = Translation[newVal];
            }
        },
        computed : {
            translationId() {
                return  Number(this.$vnode.key) +1;
            },
            languageOptions() {
                return Languages();
            },
            typeOptions() {
                return WordTypes();
            }
        },
        methods: {
            addExample() {
                this.translation.examples.push(new Example())
            },
        }
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