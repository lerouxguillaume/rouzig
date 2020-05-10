<template>
    <div class="menu-container">
        <b-button v-if="loggedIn" @click="logout">{{ $t('common.logout') }}</b-button>
        <b-button v-else v-b-modal="loginModalId">{{ $t('common.login') }}</b-button>
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
        <login
            :id="loginModalId"
        ></login>
    </div>
</template>

<script>
    import LinkButton from "../Utils/LinkButton";
    import {mapActions, mapGetters} from "vuex";
    import Login from "../Security/Login";
    export default {
        name: 'NavigationMenu',
        components: {Login, LinkButton},
        data: () => {
            return {
                loginModalId : 'login-modal-id'
            }
        },
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
            },
            ...mapGetters('auth', [
                'loggedIn'
            ])
        },
        methods: {
            ...mapActions('auth', [
                'logout'
            ]),
            selectLang: function (lang) {
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