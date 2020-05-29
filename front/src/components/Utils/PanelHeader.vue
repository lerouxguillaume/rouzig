<template>
    <div class="navigation-form ">
        <div  @click="changePage(1)" class="col-6 box">
            <span class="text-center">{{ $t('panel.translation') }}</span>
            <div :class="(page === 1 ? 'active' : 'inactive')"></div>
        </div>
        <div  @click="changePage(2)" class="col-6 box">
            <span class="text-center"> {{ $t('panel.examples') }} </span>
            <div :class="(page === 2 ? 'active' : 'inactive')"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PanelHeader",
        props: {
            currentPage: {
                type: Number
            },
        },
        data: () => {
            return {
                page: 1,
            }
        },
        watch: {
            page: {
                immediate: true,
                handler(val) {
                    this.page = val;
                }
            }
        },
        methods: {
            changePage(page) {
                this.page = page
                this.handleInput();
            },
            handleInput() {
                this.$emit('input', this.page)
            }
        },
    }
</script>

<style scoped>
    .navigation-form {
        margin-bottom: 20px;
        flex-grow: 1;
    }
    .box {
        flex-direction: column;
        justify-content: center;
    }

    .active {
        height: 2px;
        background: linear-gradient(to left, orange, red);
    }
    .inactive {
        height: 2px;
        background: gray;
    }

</style>