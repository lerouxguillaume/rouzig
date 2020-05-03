<template>
    <div class="search-container">
        <b-input-group class="search-bar">
            <b-input
                    type="text"
                    v-model="searchValue"
                    :placeholder="$t('search.search')"
                    @change="search(searchValue)"
            ></b-input>
            <b-button type="button" @click="search(searchValue)">{{ $t('search.search') }}</b-button>
        </b-input-group>
    </div>
</template>

<script>
    export default {
        name: "SearchBar",
        props: {
            search: {
                type: Function,
                required: true
            }
        },
        data() {
            return {
                searchValue: '',
            }
        },
        methods: {

        }
    }
</script>

<style scoped>
    .search-container {
        display: flex;
        align-content: center;
        justify-content: center;
    }
    .search-bar {
        width: 80%;
        max-width: 500px;
    }
</style>