<template>
    <div :class="'input '+ className" role="group">
        <label :for="id">{{label}}:</label>
        <b-input
                :id="id"
                :type="type"
                v-model="content"
                :placeholder="placeholder"
                trim
                :state="this.errorMessage.length > 0 ? false : null"
                @input="handleInput"
                :readonly="readonly"
        >
        </b-input>
        <b-form-invalid-feedback>
            {{ $t(errorMessage) }}
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
            type: {
                type: String,
                default: 'text'
            },
            placeholder: {
                type: String
            },
            error: {
                type: String,
            },
            className: {
                type: String
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
            },
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
    }
</style>