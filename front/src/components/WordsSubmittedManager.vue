<template>
    <div class="word-not-found table">
        <b-table striped hover
                 :fields="fields"
                 :busy="items.length === 0"
                 :items="items"
                 :per-page="rowPerPage"
                 :current-page="currentPage"
        >
            <template v-slot:cell(action)="data">
                <router-link :to="{name: 'ReviewWord', params: {id : data.item.id}}">{{ $t('review.label') }} {{data.item.id}} </router-link>
            </template>
            <template v-slot:cell(updatedAt)="data">
                {{ data.item.updatedAt | moment("calendar") }}
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
    import {Status} from "../utils/enum";
    import {Definition} from "../entities/Definition";

    export default {
        name: "WordsSubmittedManager",
        data() {
            return {
                fields: [
                  'text', 'status', 'updatedAt', 'action'
                ],
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
                        'page': ctx.currentPage,
                        'status': Status.pending
                    }
                };

                ApiService.get(process.env.VUE_APP_API_URL + 'words', params)
                    .then((response) => {
                        let items = [];
                        let meta = response.data.meta;
                        let data = response.data.data;
                        this.totalRows = meta.totalItems;
                        this.rowPerPage = meta.itemsPerPage;
                        data.forEach((datum) => {
                            if (typeof datum !== 'undefined') {
                                let newDefinition = new Definition();
                                newDefinition.load(datum);
                                items.push(newDefinition)
                            }
                        })
                        callback(items)
                    })
                    .catch(function (error) {
                        console.error(error);
                        callback([]);
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