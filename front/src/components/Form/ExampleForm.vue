<template>
    <b-card
            header-bg-variant="secondary"
            border-variant="secondary"
            :header="$t('common.example') + ' ' +  this.exampleId "
    >
        <div class="example-container">
            <div class="row">
                <TextAreaInput
                        :id="'input-from-textarea-' + this.exampleId"
                        :label="$t('form.example-from.label')"
                        v-model="example.fromText"
                        :placeholder="$t('form.example-from.placeholder')"
                        :error="$t(example.fromTextError)"
                ></TextAreaInput>
            </div>
            <div class="row">
                <TextAreaInput
                        :id="'input-to-textarea-' + this.exampleId"
                        :label="$t('form.example-to.label')"
                        v-model="example.toText"
                        :placeholder="$t('form.example-to.placeholder')"
                        :error="$t(example.toTextError)"
                ></TextAreaInput>
            </div>
            <div class="row">
                <b-button type="button" variant="danger" @click="onRemoveExample(example)" block>{{ $t('form.delete-example') }}</b-button>
            </div>
        </div>
    </b-card>
</template>

<script>
    import {Example} from "../../entities/Example";
    import {Translation} from "../../utils/enum";
    import TextAreaInput from "./TextAreaInput";

    export default {
        name: "ExampleForm",
        components: {TextAreaInput},
        props : {
            example: {
                type: Example,
                required: true
            },
            onRemoveExample: {
                type: Function,
                required: true
            },
            language: {
                type: String
            }
        },
        watch: {
            language: function (newVal) {
                this.example.fromLanguage = newVal;
                this.example.toLanguage = Translation[newVal];
                console.log(newVal)
            }
        },
        computed: {
            exampleId() {
                return  Number(this.$vnode.key) + 1;
            }
        }
    }
</script>

<style scoped>
    .example-container {
        flex-direction: column;
        flex-grow: 1;
    }
</style>