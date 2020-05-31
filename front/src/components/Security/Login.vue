<template>
    <b-modal :id="id"
             :ref="modalRef"
             header-bg-variant="primary"
    >
        <b-overlay :show="submitted" rounded="sm" no-wrap></b-overlay>
        <div class="login-container flex-column flex-grow-1">
            <div v-show="loginError">
                {{ $t(loginError) }}
            </div>
            <div class="row">
                <label>{{ $t('login.username.label') }} : </label>
                <b-input id="login" type="text" :placeholder="$t('login.username.placeholder')" v-model="email"/>
            </div>
            <div class="row">
                <label>{{ $t('login.password.label') }} : </label>
                <b-input id="password" type="password" v-model="password"/>
            </div>
            <div class="row flex-column">
                <p>
                    <RouterLink v-on:click.native="closeModal" :to="{name: 'ResetPassword', params:{lang: $i18n.locale}}">{{ $t('login.link.forgot_password') }}</RouterLink>
                </p>
                <br>
                <p>{{ $t('login.text.no_account') }}
                    <RouterLink v-on:click.native="closeModal" :to="{name: 'Register', params:{lang: $i18n.locale}}">{{ $t('login.link.register') }}</RouterLink>
                </p>
            </div>
        </div>
        <template v-slot:modal-header>
            <b-button type="submit" variant="primary">{{ $t('login.header') }}</b-button>
        </template>
        <template v-slot:modal-footer>
            <div class="flex-grow-1 justify-center">
                <b-button type="submit" variant="primary" @click="handleSubmit">{{ $t('form.submit') }}</b-button>
            </div>
        </template>
    </b-modal>
</template>
<script>
    import { mapGetters, mapActions } from "vuex";
    export default {
        name: "login",
        props: {
            id : {
                type: String,
                default: 'login-modal-id'
            },
            modalRef : {
                type: String,
                default: 'login-modal-ref'
            },
        },
        data() {
            return {
                email: "",
                password: "",
                loginError: null,
                submitted : false
            };
        },
        computed: {
            ...mapGetters('auth', [
                'authenticating',
                'authenticationError',
                'authenticationErrorCode',
                'loggedIn'
            ])
        },
        mounted() {
            if (this.loggedIn) {
                this.closeModal()
            }
        },
        methods: {
            ...mapActions('auth', [
                'login',
                'userInfo'
            ]),
            handleSubmit() {
                // Perform a simple validation that email and password have been typed in
                if (this.email != '' && this.password != '') {
                    this.submitted = true;
                    this.login({email: this.email, password: this.password})
                        .then((success) => {
                            if (success) {
                                this.userInfo();
                                this.closeModal();
                            }  else {
                                this.loginError = 'login.invalid'
                            }
                            this.submitted = false;
                        })
                    this.password = ""
                }
            },
            closeModal() {
                this.$refs[this.modalRef].hide()
            }
        }
    };
</script>

<style scoped>
    .login-container {
        justify-content: center;
        margin: 0 5%;
    }
    .row {
        margin: 10px 0;
    }
    .justify-center {
        justify-content: center;
    }
</style>