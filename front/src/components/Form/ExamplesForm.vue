<template>
    <div class="examples-form-container">
        <ExampleForm
                v-for="(example, index) in examples"
                :key="index"
                :example="example"
                :on-remove-example="removeExample"
                :language="language"
                :readonly="readonly"
        ></ExampleForm>
        <div class="add-example-button-container">
            <b-button :disabled="readonly" variant="success" type="button" class="add-exemple-button" @click="addExample">{{ $t('form.add-example') }}</b-button>
        </div>
    </div>
</template>

<script>
    import ExampleForm from "./ExampleForm";
    import {Example} from "../../entities/Example";

    export default {
        name: "ExemplesForm",
        components: {ExampleForm},
        props: {
            examples: {
                type: Array,
                required: true
            },
            language: {
                type: String
            },
            readonly: {
                type: Boolean,
                default: false
            }
        },
        mounted() {
            if (this.examples.length === 0 && !this.readonly) {
                this.addExample();
            }
        },
        methods: {
            removeExample(element) {
                let index = this.examples.indexOf(element);

                if (index >= 0) {
                    this.examples.splice(index,1);
                }
            },
            addExample() {
                this.examples.push(new Example())
            }
        }
    }
</script>

<style scoped>
    .examples-form-container {
        flex-grow: 1;
        flex-direction: column;
        margin: 5px -5px;
    }
</style>