<template>
    <div class="word-not-found table">
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle.accordion-1 variant="primary">
                    <h3 class="text-center">{{ $t('table.my-tranlsations.title') }}</h3>
                </b-button>
            </b-card-header>
            <b-collapse id="accordion-1" visible accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <DataTable
                            reference="table_word_submitted"
                            :fields="fields"
                            :items="items"
                            :total-rows="totalRows"
                            :current-page="currentPage"
                            :show-empty="true"
                            :row-per-page="rowPerPage"
                    >
                        <template v-slot:action="data">
                            <div class="align-content-end">
                                <LinkButton classes="text-center" :to="{name: 'ReviewWord', params: {id : data.item.id, lang: $i18n.locale}}">
                                    {{ $t('common.review') }}
                                </LinkButton>
                            </div>
                        </template>
                        <template v-slot:empty>
                            <div class="center">
                                <p>{{ $t('table.review-word.empty') }}</p>
                                <LinkButton :to="{name: 'AddTranslation', params: {lang: $i18n.locale}}">
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
    import ApiService from "../../services/api.service";
    import {RelativeDate} from "../../utils/formatter";
    import LinkButton from "../Utils/LinkButton";
    import DataTable from "../Utils/DataTable";
    import {Translation} from "../../entities/Translation";
    import {mapGetters} from "vuex";

    export default {
        name: "UserTranslations",
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
            ...mapGetters('auth', [
                'userInfo'
            ]),
            fields() {
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
                        'user': this.userInfo.id
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