<template>
    <div class="table-container">
        <b-table striped hover
                 :ref="reference"
                 :fields="fields"
                 :items="items"
                 :per-page="rowPerPage"
                 :current-page="currentPageData"
                 :show-empty="showEmpty"
        >
            <template v-slot:cell(action)="data">
                <slot name="action" v-bind="data"></slot>
            </template>
            <template v-slot:empty>
                <slot name="empty"></slot>
            </template>
        </b-table>
        <b-pagination
                v-show="!isEmpty"
                align="center"
                v-model="currentPageData"
                :total-rows="totalRows"
                :per-page="rowPerPage"
                aria-controls="my-table"
        ></b-pagination>
    </div>
</template>

<script>
    export default {
        name: "DataTable",
        props: {
            currentPage: {
                type: Number
            },
            totalRows: {
                type: Number
            },
            rowPerPage: {
                type: Number,
                default: 5
            },
            fields: {
                type: Array
            },
            items: {
                required: true
            },
            showEmpty: {
                type: Boolean,
                required: false,
                default: false
            },
            reference: {
                type: String,
                required: true,
            }
        },
        computed: {
            isEmpty() {
                return false;
            }
        },
        data () {
            return {
                currentPageData: this.currentPage
            }
        },
        watch: {
            currentPage: {
                immediate: true,
                handler(val) {
                    this.currentPageData = val;
                }
            },
        },
        methods: {
            refresh() {
                this.$refs[this.reference].refresh();
            }
        }
    }
</script>

<style scoped>
    .table-container {
        flex-direction: column;
        flex-grow: 1;
    }
</style>