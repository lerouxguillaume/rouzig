<template>
    <div>
        <b-button block @click="handleChange" variant="outline-primary" class="selection-button">
            {{ originLabel }} <b-icon-arrow-left-right></b-icon-arrow-left-right> {{ destinationLabel }}
        </b-button>
    </div>
</template>

<script>
    import {Translation} from "../../utils/enum";
    import {getLanguageLabel} from "../../utils/common";

    export default {
        name: "LanguageSelection",
        props: {
            id: {
                required: true,
                type: String
            },
            origin: {
                type: String
            },
            destination: {
                type: String
            },
            readonly: {
                type: Boolean,
                default: false
            }
        },
        data () {
            return {
                originData: this.origin ?? this.$i18n.locale,
                destinationData: Translation[this.$i18n.locale]
            }
        },
        computed: {
            originLabel() {
                return getLanguageLabel(this.originData)
            },
            destinationLabel() {
                return getLanguageLabel(this.destinationData)
            }
        },
        mounted() {
            this.handleInput();
        },
        methods: {
            handleInput () {
                this.$emit('update:origin', this.originData)
                this.$emit('update:destination', this.destinationData)
            },
            handleChange () {
                let tmp = this.originData;
                this.originData = this.destinationData;
                this.destinationData = tmp;
                this.handleInput();
            }
        }
    }
</script>

<style scoped>
    .language-selection {
        /*flex-shrink: 1;*/
    }
    .selection-button {
        height: calc(1.5em + 0.75rem + 2px);
        align-self: flex-end;
    }
</style>