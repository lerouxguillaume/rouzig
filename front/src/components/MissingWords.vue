<template>
    <div class="word-not-found table">
        <b-card no-body class="card-container">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.accordion-1 variant="primary">
                    <h3 class="text-center">{{ $t('table.missing-word.title') }}</h3>
                </b-button>
            </b-card-header>
            <b-collapse id="accordion-1" visible accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <DataTable
                            :fields="fields"
                            :items="items"
                            :total-rows="totalRows"
                            :current-page="currentPage"
                    >
                        <template v-slot:action="data">
                            <div class="align-content-end">
                                <LinkButton :to="{name: 'AddTranslation', params: {word : data.item.text}}">
                                    {{ $t('common.add-translation') }}
                                </LinkButton>
                                <b-button variant="danger" @click="deleteWord(data.item)">{{ $t('common.delete') }}</b-button>
                            </div>
                        </template>
                    </DataTable>
                </b-card-body>
            </b-collapse>
        </b-card>
    </div>
</template>

<script>
    import ApiService from "../services/api.service";
    import {RelativeDate} from "../utils/formatter";
    import LinkButton from "./Utils/LinkButton";
    import DataTable from "./Utils/DataTable";

    export default {
        name: "MissingWords",
        // eslint-disable-next-line vue/no-unused-components
        components: {DataTable, LinkButton},
        data() {
            return {
                rowPerPage : 5,
                currentPage : 1,
                totalRows : 0,
                items: this.itemsProvider
            }
        },
        computed: {
            fields() {
                return [
                    {
                        key: 'text',
                        label: this.$i18n.t('table.text-label')
                    },
                    {
                        key: 'count',
                        label: this.$i18n.t('table.count-label')
                    },
                    {
                        key: 'lastSearch',
                        label: this.$i18n.t('table.lastSearch-label'),
                        formatter: RelativeDate
                    },
                    {
                        key: 'action',
                        label: this.$i18n.t('table.action-label'),
                        class: 'text-right'
                    },
                ]
            }
        },
        methods: {
            itemsProvider(ctx, callback) {
                let params = {
                    'params' : {
                        'page': ctx.currentPage,
                        'itemPerPage': ctx.perPage,
                    }
                };

                ApiService.get(process.env.VUE_APP_API_URL + 'searches', params)
                    .then((response) => {
                        let items = [];
                        let data = response.data['hydra:member'];
                        this.totalRows = response.data['hydra:totalItems'];
                        data.forEach((datum) => {
                            items.push({
                                'text': datum.text,
                                'count': datum.count,
                                'lastSearch': datum.updatedAt
                            })
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
    .word-not-found {
        flex-grow: 1;
    }
    .card-container {
        flex-grow: 1;
    }
    .card-body {
        flex-grow: 1;
    }
</style>