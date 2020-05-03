<template>
    <div class="input" role="group">
        <label :for="id">{{label}}:</label>
        <b-input
                :id="id"
                v-model="content"
                :placeholder="placeholder"
                trim
                :state="error != null ? false : null"
                @input="handleInput"
        >
        </b-input>
        <b-form-invalid-feedback>
            {{ error }}
        </b-form-invalid-feedback>
    </div>
</template>

<script>
    export default {
        name: "TextInput",
        props: {
            id: {
                required: true,
                type: String
            },
            value: {
                type: String
            },
            label: {
                required: true,
                type: String
            },
            placeholder: {
                type: String
            },
            error: {
                type: String,
            }
        },
        data () {
            return {
                content: this.value
            }
        },

        methods: {
            handleInput () {
                this.$emit('input', this.content)
            }
        }
    }
</script>

<style scoped>

</style>