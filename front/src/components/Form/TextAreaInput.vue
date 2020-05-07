<template>
    <div class="input" role="group">
        <label :for="id">{{label}}:</label>
        <b-textarea
                :id="id"
                v-model="content"
                :placeholder="placeholder"
                trim
                :state="this.errorMessage.length > 0 ? false : null"
                @input="handleInput"
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

</style>