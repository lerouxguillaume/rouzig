<template>
    <div class="register-container">
        <b-card
                header-bg-variant="primary"
                border-variant="primary"
                :header="$t('register.activate.header')"
        >
            {{ message }}
        </b-card>
    </div>
</template>

<script>

    import ApiService from "../../services/api.service";

    export default {
        name: "Activate",
        data(){
            return {
                message: 'verification en cours'
            }
        },
        mounted() {
            let token = this.$route.query.token;

            if (token.length > 0)
            {
                let options = {
                    headers: { 'Content-Type': 'application/json' },
                };
                ApiService.post(process.env.VUE_APP_API_URL + 'users/activate', {
                    token : token,
                }, options)
                    .then(() => {
                        this.message = this.$t('register.activate.success');
                    })
                    .catch((error) => {
                        console.error(error)
                        this.message = this.$t('register.activate.error', {"error" : error.response.message});
                    })
            } else {
                alert('no token');
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
</style>