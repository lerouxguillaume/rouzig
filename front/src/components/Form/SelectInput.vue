<template>
    <div :class="'input '+ className" role="group">
        <label :for="id">{{label}}:</label>
        <b-select
                :id="id"
                v-model="content"
                trim
                :state="this.error.length > 0 ? false : null"
                @input="handleInput"
                :options="options"
                :disabled="readonly"
        >
        </b-select>
        <b-form-invalid-feedback>
            {{ errorMessage }}
        </b-form-invalid-feedback>
    </div>
</template>

<script>
    export default {
        name: "SelectInput",
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
            options: {
                type: Array,
                default: () => {return []}
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