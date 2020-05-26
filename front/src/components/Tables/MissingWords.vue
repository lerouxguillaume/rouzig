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
                            ref="table"
                            reference="table_word_not_found"
                            :fields="fields"
                            :items="items"
                            :total-rows="totalRows"
                            :current-page="currentPage"
                    >
                        <template v-slot:action="data">
                            <div class="align-content-end">
                                <LinkButton :to="{name: 'AddTranslation', params: {word : data.item.text, lang: $i18n.locale}}">
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
    import ApiService from "../../services/api.service";
    import {RelativeDate} from "../../utils/formatter";
    import LinkButton from "../Utils/LinkButton";
    import DataTable from "../Utils/DataTable";

    export default {
        name: "MissingWords",
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
                        callback([]);
                    })
            },
            deleteWord(word) {
                let options = {
                    headers: { 'Content-Type': 'application/json' },
                };
                ApiService.delete(process.env.VUE_APP_API_URL + 'searches/'+ word.text ,options)
                    .then(() => {
                        this.$refs.table.refresh()
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