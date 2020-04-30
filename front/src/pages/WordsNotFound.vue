<template>
    <div class="word-not-found table">
        s
        <b-table striped hover :items="items"></b-table>
    </div>
</template>

<script>
    import ApiService from "../../services/api.service";

    export default {
        name: "WordManager",
        data() {
            return {
            }
        },
        methods: {
            items(ctx, callback) {
                let params = {
                    'headers' : {
                        'Accept' : 'application/vnd.api+json'
                    },
                    'params' : {
                        'page': ctx.page
                    }
                };

                ApiService.get(process.env.VUE_APP_API_URL + 'searches', params)
                    .then((response) => {
                        let items = [];
                        console.log(response)
                        let data = response.data.data;
                        console.log(data)
                        data.forEach((datum) => {
                            if (typeof datum !== 'undefined') {
                                let attributes = datum.attributes;
                                items.push({
                                    'text': attributes.text,
                                    'count': attributes.count,
                                    'lastSearch': attributes.updatedAt
                                })
                            }
                        })
                        callback(items)
                    })
                    .catch(function (error) {
                        console.error(error);
                    })
            },
            submit() {
                let options = {
                    headers: { 'Content-Type': 'application/json' },
                };
                ApiService.post(process.env.VUE_APP_API_URL + 'words', JSON.stringify(this.word, (key, value) => {
                    if (value !== null) return value
                }) ,options)
                    .then((response) => {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.error(error);
                    })
            }
        }
    }
</script>

<style scoped>
    .word-manager-container {
        display: flex;
        flex-direction: column;
        margin: 0 5%;
    }
    .submit-button-container {
        display: flex;
        flex-grow: 1;
        margin: 25px 0;
    }
    .submit-button {
        width: 100%;
    }

</style>