<template>
    <div class="login-container">
        <h4>Identification</h4>
        <b-form @submit="handleSubmit">
            <b-form-group>
                <b-form-input id="login" size="lg" type="text" placeholder="Login" v-model="email"/>
            </b-form-group>
            <b-form-group>
                <b-form-input id="password" size="lg" type="password" placeholder="Password" v-model="password"/>
            </b-form-group>
            <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>
    </div>
</template>
<script>
    import { mapGetters, mapActions } from "vuex";
    export default {
        name: "login",
        data() {
            return {
                email: "",
                password: "",
            };
        },
        computed: {
            ...mapGetters('auth', [
                'authenticating',
                'authenticationError',
                'authenticationErrorCode'
            ])
        },
        methods: {
            ...mapActions('auth', [
                'login'
            ]),
            handleSubmit() {
                // Perform a simple validation that email and password have been typed in
                if (this.email != '' && this.password != '') {
                    this.login({email: this.email, password: this.password})
                    this.password = ""
                }
            }
        }
    };
</script>

<style scoped>
    .login-container {
        margin: 10% 30%;
        padding: 10px;
        min-height: 100px;
        min-width: 300px;
        background-color: white;
        box-shadow: 10px 10px 24px #555;
        border-radius: 10px;
    }
    button {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>