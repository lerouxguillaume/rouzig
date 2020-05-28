<template>
    <div class="input" role="group">
        <label :for="id">{{label}}:</label>
        <b-textarea
                :id="id"
                v-model="content"
                :placeholder="placeholder"
                :state="this.errorMessage.length > 0 ? false : null"
                @input="handleInput"
                :readonly="readonly"
                rows="4"
                trim
        >
        </b-textarea>
        <b-form-invalid-feedback>
            {{ errorMessage }}
        </b-form-invalid-feedback>
    </div>
</template>

<script>
    export default {
        name: "TextAreaInput",
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
            },
            readonly: {
                type: Boolean,
                default: false
            }
        },
        data () {
            return {
                content: this.value
            }
        },
        watch: {
            value: {
                immediate: true,
                handler(val) {
                    this.content = val;
                }
            }
        },
        computed: {
            errorMessage() {
                return (typeof this.error === 'string' && this.error.length > 0) ?  this.error : '';
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
    .input {
        flex-direction: column;
        flex-grow: 1;
    }
</style>