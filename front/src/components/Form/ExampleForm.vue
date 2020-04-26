<template>
    <div>
        <b-card
                header-bg-variant="secondary"
                border-variant="secondary"
                :header="$t('common.example') + ' ' +  this.exampleId "
        >
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
            <b-button type="button" variant="danger" @click="onRemoveExample(example)">{{ $t('form.delete-example') }}</b-button>
        </b-card>
    </div>
</template>

<script>
    import {Example} from "../../entities/Example";

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
            }
        },
        computed: {
            exampleId() {
                return  Number(this.$vnode.key) +1;
            }
        }
    }
</script>

<style scoped>
    .row {
        margin: 5px;
    }
</style>