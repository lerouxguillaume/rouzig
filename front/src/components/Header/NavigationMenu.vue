<template>
    <div>
        <b-navbar toggleable="lg" variant="primary" class="navbar">
            <b-navbar-brand :to="{name: 'homepage', params: {'lang': $i18n.locale}}">
                <img class="logo" :src="logo">
            </b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item :to="{name: 'MenuPage', params: {'lang': $i18n.locale}}">{{ $t('common.menu') }}</b-nav-item>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown right>
                        <template v-slot:button-content="" v-bind:selectedLanguage="selectedLanguage">
                            <img :src="selectedLanguage.image">
                            {{ selectedLanguage.label }}
                        </template>
                        <b-dropdown-item n v-for="(lang, key) in langs" :key="key" @click="selectLang(key)"><img :src="lang.image">{{ lang.label }}</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-button v-if="loggedIn" @click="logout" variant="primary">{{ $t('common.logout') }}</b-button>
                    <b-button v-else v-b-modal="loginModalId" variant="primary">{{ $t('common.login') }}</b-button>

                    <login
                            :id="loginModalId"
                    ></login>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>

</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import Login from "../Security/Login";
    export default {
        name: 'NavigationMenu',
        components: {Login},
        data: () => {
            return {
                loginModalId : 'login-modal-id',
                logo: require('../../assets/logo-white.png')
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
                let params = this.$route.params
                params['lang'] = lang
                this.$router.push({ name: this.$route.name, params: params })
            },

        }
    }
</script>

<style scoped>
    .navbar {
        flex-grow: 1;
    }
    .locale-changer {
        display: flex;
        justify-content: flex-start;
    }
</style>