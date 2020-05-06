<template>
    <div class="new-password-container flex-grow-1">
        <b-card
                header-bg-variant="primary"
                border-variant="primary"
                header="NewPassword"
        >
            <div class="flex-column flex-grow-1">
                    <TextInput
                            id="reset-password"
                            label="Password"
                            v-model="password"
                            type="password"
                    >
                    </TextInput>
                    <TextInput
                            id="reset-confirm-password"
                            label="Confirm password"
                            v-model="passwordConfirm"
                            type="password"
                    >
                    </TextInput>
                <div class="submit-container">
                    <b-button variant="success" type="submit" @click="handleSubmit" block>Submit</b-button>
                </div>
            </div>
        </b-card>
    </div>
</template>


<script>

    import ApiService from "../../../services/api.service";
    import TextInput from "../../components/Form/TextInput";

    export default {
        name: "NewPassword",
        components: {TextInput},
        props : ["nextUrl"],
        data(){
            return {
                password: '',
                passwordConfirm : '',
                token: this.$route.query.token

            }
        },
        mounted() {
            console.log(this.password)
        },
        methods: {
            handleSubmit(e) {
                e.preventDefault()

                if (this.password === this.passwordConfirm && this.password.length > 0)
                {
                    let options = {
                        headers: { 'Content-Type': 'application/json' },
                    };
                    ApiService.post(process.env.VUE_APP_API_URL + 'users/new-password', {
                        token : this.token,
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
                    this.password = '';
                    this.passwordConfirm = '';
                }
            }
        }
    }
</script>

<style scoped>
    .new-password-container {
        max-width: 750px;
    }
    .submit-container {
        margin-top: 10px;
    }
</style>