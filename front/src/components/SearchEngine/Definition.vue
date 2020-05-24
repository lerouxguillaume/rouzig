<template>
    <div class="definition-container">
        <div>
            <b>{{ definition.word.text }} : </b>
        </div>
        <div class="definitions-translations">
            <ol>
                <li
                        v-for="(translation, index) in definition.translations"
                        :key="index"
                >
                    {{ translation.translatedWord.text }} ({{ translation.translatedWord.wordType }}) - {{ translation.translatedWord.description }}
                    <div class="definition-example">
                        <span class="examples-header">{{ $tc('search.examples', translation.examples.length) }} :</span>
                        <ul
                                v-for="(example, index) in translation.examples"
                                :key="index"
                                class="example"
                        >
                            {{ example.fromText }} : {{ example.toText }}
                        </ul>
                    </div>

                </li>
            </ol>
        </div>
    </div>
</template>

<script>
    import {Definition} from "../../entities/Definition";

    export default {
        name: "Definition",
        props: {
            definition: {
                type: Definition,
                required: true
            }
        }, mounted() {
            console.log(this.definition)
        }
    }
</script>

<style scoped>
    .definition-container {
        display: flex;
        flex-grow: 1;
        width: 100%;
        padding: 20px;
        border: 2px solid black;
        border-radius: 10px;
    }
    ol {
        margin: 0;
    }
    .definition-example {
        display: flex;
        flex-direction: column;
        margin: 10px 0;
    }
    .examples-header {
        text-decoration: underline;
        margin: 10px 0;
    }
    .example {
        margin: 5px 0;
    }
</style>