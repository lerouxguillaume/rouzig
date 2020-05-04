<template>
    <div class="register-container">
        <b-card
                header-bg-variant="primary"
                border-variant="primary"
                header="Register"
        >
            <div class="register-form-container">
                <div class="row">
                    <TextInput
                            class-name="col-6"
                            id="username-register"
                            label="username"
                            v-model="username"
                    >
                    </TextInput>
                     <TextInput
                             class-name="col-6"
                             id="email-register"
                            label="email"
                            v-model="email"
                    >
                    </TextInput>
                </div>
                <div class="row">
                    <TextInput
                            class-name="col-6"
                            id="password-register"
                            label="Password"
                            v-model="password"
                            type="password"
                    >
                    </TextInput>
                    <TextInput
                            class-name="col-6"
                            id="password-confirm-register"
                            label="Password"
                            v-model="password_confirmation"
                            type="password"
                    >
                    </TextInput>
                </div>
                <div class="submit-container">
                    <b-button variant="success" type="submit" @click="handleSubmit" block>Submit</b-button>
                </div>
            </div>
        </b-card>
    </div>
</template>

<script>

    import TextInput from "../components/Form/TextInput";
    import ApiService from "../../services/api.service";
    export default {
        name: "Register",
        components: {TextInput},
        props : ["nextUrl"],
        data(){
            return {
                username : "test",
                email : "test@email",
                password : "test",
                password_confirmation : "test",
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
                            this.$router.push({ name:'MenuPage' })
                        })
                        .catch((error) => {
                            let response = error.response;
                            if (response.status === 400) {
                                console.log(response)
                            }
                        })
                } else {
                    this.password = ""
                    this.passwordConfirm = ""

                    return alert("Passwords do not match")
                }
            }
        }
    }
</script>

<style scoped>
    .register-container {
        max-width: 750px;
        flex-grow: 1;
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
        flex-grow: 1;
        margin-top: 10px;
    }
</style>