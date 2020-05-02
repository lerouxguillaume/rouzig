<template>
    <div class="word-not-found table">
        <b-table striped hover
                 ref="table_word_not_found"
                 :fields="fields"
                 :items="items"
                 :per-page="rowPerPage"
                 :current-page="currentPage"
        >
            <template v-slot:cell(action)="data">
                <router-link :to="{name: 'AddTranslation', params: {word : data.item.text}}">{{ $t('word.add-translation') }}</router-link>
                <b-button variant="danger" @click="deleteWord(data.item)">{{ $t('word.delete') }}</b-button>
            </template>
        </b-table>
        <b-pagination
                v-model="currentPage"
                :total-rows="totalRows"
                :per-page="rowPerPage"
                aria-controls="my-table"
        ></b-pagination>
    </div>
</template>

<script>
    import ApiService from "../../services/api.service";

    export default {
        name: "WordManager",
        data() {
            return {
                fields: ['text', 'count', 'lastSearch', 'action'],
                rowPerPage : 5,
                currentPage : 1,
                totalRows : 0,
                items: this.itemsProvider
            }
        },
        methods: {
            itemsProvider(ctx, callback) {
                let params = {
                    'headers' : {
                        'Accept' : 'application/vnd.api+json'
                    },
                    'params' : {
                        'page': ctx.currentPage
                    }
                };

                ApiService.get(process.env.VUE_APP_API_URL + 'searches', params)
                    .then((response) => {
                        let items = [];
                        let meta = response.data.meta;
                        let data = response.data.data;
                        this.totalRows = meta.totalItems;
                        this.rowPerPage = meta.itemsPerPage;
                        data.forEach((datum) => {
                            if (typeof datum !== 'undefined') {
                                let attributes = datum.attributes;
                                items.push({
                                    'id': attributes._id,
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
                        this.busy = false;
                        callback([]);
                    })
            },
            deleteWord(word) {
                let options = {
                    headers: { 'Content-Type': 'application/json' },
                };
                this.busy = true;
                ApiService.delete(process.env.VUE_APP_API_URL + 'searches/'+ word.id ,options)
                    .then(() => {
                        this.$refs.table_word_not_found.refresh()
                    })
                    .catch(function (error) {
                        console.error(error);
                    })

            },
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