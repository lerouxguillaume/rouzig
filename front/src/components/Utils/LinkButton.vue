<template>
    <div :class="block ? 'grow-link-button-container':''">
        <router-link :to="to" :class="block ? 'grow-link-button-container':''">
            <b-button :variant="variant" :block="block">
                <slot></slot>
            </b-button>
        </router-link>
    </div>
</template>

<script>
    export default {
        name: "LinkButton",
        props: {
            to: {
                type: Object,
                required: true
            },
            variant: {
                type: String,
                required: false,
                default: 'success'
            },
            block: {
                type: Boolean,
                required:false,
                default: false
            }
        }
    }
</script>

<style scoped>
    .grow-link-button-container {
        width: 100%;
    }
</style>