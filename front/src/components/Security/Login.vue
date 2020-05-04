<template>
    <b-modal :id="id"
             :ref="modalRef"
             header-bg-variant="primary"
    >
        <b-overlay :show="submitted" rounded="sm" no-wrap></b-overlay>
        <div class="login-container">
            <div class="row">
                <label>Username : </label>
                <b-input id="login" type="text" placeholder="Login" v-model="email"/>
            </div>
            <div class="row">
                <label>Password : </label>
                <b-input id="password" type="password" placeholder="Password" v-model="password"/>
            </div>
            <div class="row justify-center">
                <p>Forgot password ?</p>
                <p>No account ?
                    <RouterLink :to="{name: 'Register'}">Sign up</RouterLink>
                </p>
            </div>
        </div>
        <template v-slot:modal-header>
            <b-button type="submit" variant="primary">Identification</b-button>
        </template>
        <template v-slot:modal-footer>
            <div class="grow justify-center">
                <b-button type="submit" variant="primary" @click="handleSubmit">Submit</b-button>
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
                'login'
            ]),
            handleSubmit() {
                // Perform a simple validation that email and password have been typed in
                if (this.email != '' && this.password != '') {
                    this.submitted = true;
                    this.login({email: this.email, password: this.password})
                        .then((success) => {
                            if (success) {
                                this.closeModal()
                            }  else {
                                //TODO: login error
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
        flex-direction: column;
        justify-content: center;
        flex-grow: 1;
        margin: 0 5%;
    }
    .row {
        margin: 10px 0;
    }
    .justify-center {
        justify-content: center;
    }
    .grow {
        flex-grow: 1;
    }
</style>