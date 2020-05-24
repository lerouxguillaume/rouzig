<template>
    <div class="reset-container flex-grow-1">
        <b-card
                header-bg-variant="primary"
                border-variant="primary"
                :header="$t('reset_password.header')"
        >
            <div class="flex-column flex-grow-1">
                <div :show="message.length > 0">
                    {{ message }}
                </div>
                <TextInput
                        id="resset-password"
                        :label="$t('reset_password.form.email.label')"
                        :placeholder="$t('reset_password.form.email.placeholder')"
                        v-model="email"
                        :error="emailError === null ? null : $t(emailError)"
                >
                </TextInput>
                <div class="submit-container">
                    <b-button variant="success" type="submit" @click="handleSubmit" block>{{ $t('form.submit') }}</b-button>
                </div>
            </div>
        </b-card>
    </div>
</template>

<script>
    import TextInput from "../../components/Form/TextInput";
    import {ValidateEmail} from "../../utils/common";
    import ApiService from "../../services/api.service";
    export default {
        name: "ResetPassword",
        components: {TextInput},
        data: () => {
            return {
                email : '',
                emailError : null,
                message: ''
            }
        },
        watch: {
            email() {
                this.emailError = null;
            }
        },
        methods: {
            handleSubmit() {
                if (!ValidateEmail(this.email)) {
                    this.emailError = 'error.input.email';
                } else {
                    let options = {
                        headers: { 'Content-Type': 'application/json' },
                    };
                    ApiService.post(process.env.VUE_APP_API_URL + 'users/reset-password', {
                        email : this.email,
                    }, options)
                        .then(() => {
                            this.message = this.$t('reset_password.success');
                        })
                        .catch((error) => {
                            console.error(error)
                            this.message = this.$t('reset_password.error', error.response.message);
                        })
                }
            }
        }
    }
</script>

<style scoped>
    .reset-container {
        max-width: 750px;
    }
    .submit-container {
        margin-top: 10px;
    }
</style>