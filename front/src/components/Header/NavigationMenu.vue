<template>
    <div class="menu-container">
        <router-link :to="{name: 'MenuPage'}">{{ $t('menu.label') }}</router-link>
        <div class="locale-changer">
            <b-dropdown>
                <template v-slot:button-content="" v-bind:selectedLanguage="selectedLanguage">
                    <img :src="selectedLanguage.image">
                    {{ selectedLanguage.label }}
                </template>
                <b-dropdown-item n v-for="(lang, key) in langs" :key="key" @click="selectLang(key)"><img :src="lang.image">{{ lang.label }}</b-dropdown-item>
            </b-dropdown>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'NavigationMenu',
        data () {
            return {
                langs: {
                    'br': {
                        'image': require('../../assets/images/flag-br.png'),
                        'label': 'Breton'
                    },
                    'fr': {
                        'image': require('../../assets/images/flag-fr.png'),
                        'label': 'Francais'
                    }
                }
            }
        },
        computed: {
            selectedLanguage() {
                return this.langs[this.$i18n.locale]
            }
        },
        methods: {
            selectLang: function (lang) {

                console.log(lang)
                this.$i18n.locale = lang
                console.log(this.$moment.locale())
                this.$moment.locale('fr')
                console.log(this.$moment.locale())
            },
        }
    }
</script>

<style scoped>
    .menu-container {
        display: flex;
        justify-content: flex-end;
    }
    .locale-changer {
        display: flex;
        justify-content: flex-start;
    }
</style>