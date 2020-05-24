<template>
    <div class="word-not-found table">
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.accordion-1 variant="primary">
                    <h3 class="text-center">{{ $t('table.review-word.title') }}</h3>
                </b-button>
            </b-card-header>
            <b-collapse id="accordion-1" visible accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <DataTable
                            :fields="fields"
                            :items="items"
                            :total-rows="totalRows"
                            :current-page="currentPage"
                            :show-empty="true"
                            :row-per-page="rowPerPage"
                    >
                        <template v-slot:action="data">
                            <div class="align-content-end">
                                <LinkButton classes="text-center" :to="{name: 'ReviewWord', params: {id : data.item.id}}">
                                    {{ $t('common.review') }}
                                </LinkButton>
                            </div>
                        </template>
                        <template v-slot:empty>
                            <div class="center">
                                <p>{{ $t('table.review-word.empty') }}</p>
                                <LinkButton :to="{name: 'AddTranslation'}">
                                    {{ $t('common.create') }}
                                </LinkButton>
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
    import {Translation} from "../entities/Translation";
    import Constant from "../utils/const";

    export default {
        name: "WordsSubmittedManager",
        components: {LinkButton, DataTable},
        data() {
            return {
                rowPerPage : 5,
                currentPage : 1,
                totalRows : 0,
                items: this.itemsProvider
            }
        },
        computed : {
            fields () {
                return [
                    {
                        key: 'originalWord.languageLabel',
                        label: this.$i18n.t('table.language-from-label')
                    },
                    {
                        key: 'originalWord.text',
                        label: this.$i18n.t('table.text-from-label')
                    },
                    {
                        key: 'translatedWord.languageLabel',
                        label: this.$i18n.t('table.language-to-label')
                    },
                    {
                        key: 'translatedWord.text',
                        label: this.$i18n.t('table.text-to-label')
                    },
                    {
                        key: 'statusLabel',
                        label: this.$i18n.t('table.status-label')
                    },
                    {
                        key: 'updatedAt',
                        label: this.$i18n.t('table.updatedAt-label'),
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
                        'status': Constant.REVIEW
                    }
                };

                ApiService.get(process.env.VUE_APP_API_URL + 'translations', params)
                    .then((response) => {
                        let items = [];
                        let data = response.data['hydra:member'];
                        this.totalRows = response.data['hydra:totalItems'];
                        data.forEach((datum) => {
                            if (typeof datum !== 'undefined') {
                                let newTranslation = new Translation();
                                newTranslation.load(datum);
                                items.push(newTranslation)
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
    .word-not-found {
        justify-content: center;
        flex-grow: 1;
    }
    .mb-1 {
        flex-grow: 1;
    }
    .center {
        flex-grow: 1;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>