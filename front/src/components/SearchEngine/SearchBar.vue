<template>
    <div class="search-container">
        <input
                type="text"
                v-model="searchValue"
                :placeholder="$t('search.search')"
                @change="search(searchValue)"
        >
        <button type="button" @click="search(searchValue)">{{ $t('search.search') }}</button>
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
</style>