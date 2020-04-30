<template>
    <div class="examples-form-container">
        <ExampleForm
                v-for="(example, index) in examples"
                :key="index"
                :example="example"
                :on-remove-example="removeExample"
                :language="language"
        ></ExampleForm>
    </div>
</template>

<script>
    import ExampleForm from "./Form/ExampleForm";

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
            }
        },
        methods: {
            removeExample(element) {
                let index = this.examples.indexOf(element);

                if (index >= 0) {
                    this.examples.splice(index,1);
                }
            },
        }
    }
</script>

<style scoped>

</style>