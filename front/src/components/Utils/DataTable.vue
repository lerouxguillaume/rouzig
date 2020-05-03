<template>
    <div class="table-container">
        <b-table striped hover
                 ref="table_word_not_found"
                 :fields="fields"
                 :items="items"
                 :per-page="rowPerPage"
                 :current-page="currentPage"
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
                v-model="currentPage"
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
            }
        },
        computed: {
            isEmpty() {
                return false;
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