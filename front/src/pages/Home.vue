<template>
    <div>s
        <input type="text" @change="search">
        {{ searchValue }}
    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                searchValue: 'd',
            }
        },
        mounted() {
          console.log(this.searchValue)
        },
        methods: {
            search() {
                console.log('dd',this.searchValue);
            }
        }
    }
</script>

<style scoped>

</style>