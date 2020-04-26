<template>
    <div>
        <b-card
                header-bg-variant="primary"
                border-variant="primary"
                :header="$t('common.traduction') + ' ' + this.translationId "
        >
            <div class="row">
                <div class="input" role="group">
                    <label for="'form-translation-text-' +  this.translationId">{{ $t('form.translation-name.label') }}:</label>
                    <b-input :id="'form-translation-text-' +  this.translationId" v-model="translation.text" :placeholder="$t('form.translation-name.placeholder')" trim></b-input>
                </div>
                <div class="input">
                    <label for="'form-translation-option-' +  this.translationId">{{ $t('form.type.label') }}:</label>
                    <b-form-select  :id="'form-translation-option-' +  this.translationId" v-model="translation.type" :options="typeOptions" trim></b-form-select>
                </div>
            </div>
            <div class="row">
                <label :for="'description-textarea-' + this.translationId">{{ $t('form.description.name') }}</label>
                <b-form-textarea
                        :id="'description-textarea-' + this.translationId"
                        v-model="translation.description"
                        :placeholder="$t('form.description.placeholder')"
                        rows="3"
                        trim
                ></b-form-textarea>
            </div>
            <ExemplesForm :examples="translation.examples">
            </ExemplesForm>
            <div class="delete-button-container">
                <b-button variant="success" type="button" class="add-exemple-button" @click="addExample">{{ $t('form.add-example') }}</b-button>
                <b-button type="button" variant="danger" class="delete-translation-button" @click="onRemoveTranslation(translation)">{{ $t('form.delete-translation') }}</b-button>
            </div>
        </b-card>
    </div>
</template>

<script>
    import {Translation} from "../../entities/Translation";
    import ExemplesForm from "../ExamplesForm";
    import {Example} from "../../entities/Example";
    import {Languages, Types} from "../../utils/enum";

    export default {
        name: "TanslationForm",
        components: {ExemplesForm},
        props: {
            translation: Translation,
            onRemoveTranslation: {
                type: Function,
                required: true
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
                return Types();
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
    .delete-button-container {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }
    .row {
        margin: 5px;
    }
</style>