<template>
    <div class="home-container">
        <SearchBar :search="search"></SearchBar>
        <div class="definitions-container">
            <p class="definitions-header" v-if="definitions.length > 0">{{ $tc('search.results', definitions.length, { nbResults: definitions.length}) }}</p>
            <Definition
                    v-for="(definition, index) in definitions"
                    :key="index"
                    :definition="definition"
            >
            </Definition>
        </div>
    </div>
</template>

<script>
    import SearchBar from "../components/SearchEngine/SearchBar";
    import ApiService from "../services/api.service";
    import Definition from "../components/SearchEngine/Definition";
    import {Word} from "../entities/Word";

    export default {
        name: "Home",
        components: {Definition, SearchBar},
        data() {
            return {
                definitions: []
            }
        },
        methods: {
            search(value) {
                let params = {
                    'params' : {
                        'search': value
                    }
                };
                this.definitions = [];
                let _this = this;

                ApiService.get(process.env.VUE_APP_API_URL + 'words', params)
                    .then((response) => {
                        response.data.data.forEach(function (elem) {
                            let newDefinition = new Word();
                            newDefinition.load(elem);
                            _this.definitions.push(newDefinition)
                        })
                    })
                    .catch(function (error) {
                        console.error(error);
                    })
            }
        }
    }
</script>

<style scoped>
    .home-container {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .definitions-container {
        margin: 20px 5%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .definitions-header {
        align-self: baseline;
    }
</style>