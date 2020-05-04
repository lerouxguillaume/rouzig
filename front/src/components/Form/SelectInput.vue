<template>
    <div class="input" role="group">
        <label :for="id">{{label}}:</label>
        <b-select
                :id="id"
                v-model="content"
                trim
                :state="error != null ? false : null"
                @input="handleInput"
                :options="options"
        >
        </b-select>
        <b-form-invalid-feedback>
            {{ error ? $t('error.'+error) : ''}}
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