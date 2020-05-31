<template>
    <b-form>
        <div class="row">
            <PanelHeader v-model="page"></PanelHeader>
        </div>
        <div class="grow">
            <transition name="component-fade" mode="out-in">
                <component v-bind:is="currentComponent" v-bind="props"></component>
            </transition>
        </div>
        <slot name="submit"></slot>
    </b-form>
</template>
(
<script>
    import ExamplesForm from "./ExamplesForm";
    import {Translation} from "../../entities/Translation";
    import PanelHeader from "../Utils/PanelHeader";
    import WordForm from "./WordForm";
    export default {
        name: "TranslationForm",
        components: {WordForm, PanelHeader, ExamplesForm},
        props: {
            translation: {
                required: true,
                type: Translation
            },
            readonly: {
                type: Boolean,
                default: false
            }
        },
        data () {
            return {
                page: 1,
                components: [
                    {
                        key: WordForm,
                        props: {
                            translation: this.translation,
                            readonly: this.readonly
                        }
                    },
                    {
                        key: ExamplesForm,
                        props: {
                            examples: this.translation.examples,
                            readonly: this.readonly
                        }
                    },
                ]
            }
        },
        computed: {
            currentComponent() {
                return this.components[this.page - 1].key;
            },
            props() {
                return this.components[this.page - 1].props;
            },
            wordType() {
                return this.translation.originalWord.wordType;
            }
        },
        watch: {
            wordType(newVal) {
                this.translation.translatedWord.wordType = newVal;
            }
        }
    }
</script>

<style scoped>
    .component-fade-enter-active, .component-fade-leave-active {
        transition: opacity .3s ease;
    }
    .component-fade-enter, .component-fade-leave-to
        /* .component-fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>