<template>
    <b-card
            header-bg-variant="secondary"
            border-variant="secondary"
            :header="$t('common.example') + ' ' +  this.exampleId "
    >
        <div class="example-container">
            <div class="row">
                <label :for="'text-input-from-'+ this.exampleId">{{ $t('form.example-from.label') }}:</label>
                <b-form-textarea
                        :id="'text-input-from-'+ this.exampleId"
                        v-model="example.fromText"
                        :placeholder="$t('form.example-from.placeholder')"
                        rows="3"
                        trim
                ></b-form-textarea>
            </div>
            <div class="row">
                <label :for="'text-to-from-'+ this.exampleId">{{ $t('form.example-to.label') }}:</label>
                <b-form-textarea
                        :id="'text-to-from-'+ this.exampleId"
                        v-model="example.toText"
                        :placeholder="$t('form.example-to.placeholder')"
                        rows="3"
                        trim
                ></b-form-textarea>
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

    export default {
        name: "ExampleForm",
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