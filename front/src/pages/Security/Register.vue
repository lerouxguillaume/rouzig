<template>
    <div class="register-container">
        <div v-if="!registerSuccess" class="register-form-container">
            <div class="row">
                <TextInput
                        class-name="col-6"
                        id="username-register"
                        :label="$t('register.form.username.label')"
                        :placeholder="$t('register.form.username.placeholder')"
                        v-model="username"
                >
                </TextInput>
                <TextInput
                        class-name="col-6"
                        id="email-register"
                        :label="$t('register.form.email.label')"
                        :placeholder="$t('register.form.email.placeholder')"
                        v-model="email"
                >
                </TextInput>
            </div>
            <div class="row">
                <TextInput
                        class-name="col-6"
                        id="password-register"
                        :label="$t('register.form.password.label')"
                        v-model="password"
                        type="password"
                        :error="passwordError.length > 0 ? $t(passwordError) : null"
                >
                </TextInput>
                <TextInput
                        class-name="col-6"
                        id="password-confirm-register"
                        :label="$t('register.form.password_confirm.label')"
                        v-model="password_confirmation"
                        type="password"
                >
                </TextInput>
            </div>
            <div class="submit-container">
                <b-button variant="success" type="submit" @click="handleSubmit" block>{{ $t('form.submit') }}</b-button>
            </div>
        </div>
        <div v-else class="alert-success">{{$t('register.form.success')}}</div>
    </div>
</template>

<script>

    import TextInput from "../../components/Form/TextInput";
    import ApiService from "../../services/api.service";
    export default {
        name: "Register",
        components: {TextInput},
        props : ["nextUrl"],
        data(){
            return {
                registerSuccess : false,
                username : "",
                email : "",
                password : "",
                password_confirmation : "",
                passwordError: ''
            }
        },
        methods : {
            handleSubmit(e) {
                e.preventDefault()

                if (this.password === this.password_confirmation && this.password.length > 0)
                {
                    let options = {
                        headers: { 'Content-Type': 'application/json' },
                    };
                    ApiService.post(process.env.VUE_APP_API_URL + 'users', {
                        username : this.username,
                        email: this.email,
                        password: this.password
                    }, options)
                        .then(() => {
                            this.registerSuccess = true
                        })
                        .catch((error) => {
                            let response = error.response;
                            if (response.status === 400) {
                                console.log(response)
                            }
                        })
                } else {
                    this.passwordError = this.$t();
                    this.password = ""
                    this.passwordConfirm = ""
                }
            }
        }
    }
</script>

<style scoped>
    .register-container {
        max-width: 750px;
        flex-grow: 1;
        height: max-content;
    }
    .register-form-container {
        margin-top: -10px;
        flex-direction: column;
        flex-grow: 1;
    }
    .row {
        margin: 5px -15px;
    }
    .submit-container {
        margin-top: 10px;
    }
</style>