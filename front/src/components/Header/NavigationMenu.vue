<template>
    <div class="menu-container">
        <LinkButton :to="{name: 'MenuPage'}" variant="primary">
            {{ $t('common.menu') }}
        </LinkButton>
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
    import LinkButton from "../Utils/LinkButton";
    export default {
        name: 'NavigationMenu',
        components: {LinkButton},
        computed: {
            langs() {
                return {
                    'br': {
                        'image': require('../../assets/images/flag-br.png'),
                        'label': this.$i18n.t('common.language.breton')
                    },
                    'fr': {
                        'image': require('../../assets/images/flag-fr.png'),
                        'label': this.$i18n.t('common.language.french')
                    }
                }
            },
            selectedLanguage() {
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
        justify-content: flex-end;
    }
    .locale-changer {
        display: flex;
        justify-content: flex-start;
    }
</style>