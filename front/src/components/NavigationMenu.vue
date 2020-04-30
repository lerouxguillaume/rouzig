<template>
    <div class="menu-container">
        <router-link :to="{name: 'wordsNotFound'}">{{ $t('menu.words-not-found') }}</router-link>
        <router-link :to="{name: 'wordManager'}">{{ $t('menu.create-word') }}</router-link>
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
                        'image': require('../assets/images/flag-br.png'),
                        'label': 'Breton'
                    },
                    'fr': {
                        'image': require('../assets/images/flag-fr.png'),
                        'label': 'Francais'
                    }
                }
            }
        },
        computed: {
            selectedLanguage() {
                console.log(this.$i18n.locale)
                return this.langs[this.$i18n.locale]
            }
        },
        methods: {
            selectLang: function (lang) {
                console.log(lang)
                this.$i18n.locale = lang
            },
        }
    }
</script>

<style scoped>
    .menu-container {
        display: flex;
        justify-content: end;
    }
    .locale-changer {
        display: flex;
        justify-content: flex-start;
    }
</style>