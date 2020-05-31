<template>
    <div class="word-manager-container form">
        <TranslationForm :translation="translation">
            <template v-slot:submit>
                <div class="submit-button-container">
                    <b-button variant="danger" type="submit" class="submit-button" @click="deleteTranslation">{{ $t('review.delete') }}</b-button>
                    <b-button variant="primary" type="submit" class="submit-button" @click="updateTranslation">{{ $t('review.update') }}</b-button>
                    <b-button variant="success" type="submit" class="submit-button" @click="validateTranslation">{{ $t('review.valid') }}</b-button>
                </div>
            </template>
        </TranslationForm>
    </div>
</template>

<script>
    import ApiService from "../services/api.service";
    import {Translation} from "../entities/Translation";
    import TranslationForm from "../components/Form/TranslationForm";

    export default {
        name: "ReviewWord",
        components: {TranslationForm},
        data() {
            return {
                'translation' : new Translation(),
            }
        },
        mounted() {
            ApiService.get(process.env.VUE_APP_API_URL + 'translations/'+this.$route.params.id)
                .then((response) => {
                    let data = response.data;
                    if (typeof data !== 'undefined') {
                        this.translation.load(data);
                    }
                })
                .catch(function (error) {
                    console.error(error);
                })
        },
        methods: {
            updateTranslation() {
                ApiService.patch(process.env.VUE_APP_API_URL + 'translations/'+this.$route.params.id , JSON.stringify(this.translation.patch(), (key, value) => {
                    if (value !== null) return value
                }))
                    .then((response) => {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.error(error);
                    })

            },
            deleteTranslation() {
                ApiService.delete(process.env.VUE_APP_API_URL + 'translations/'+this.$route.params.id)
                    .then((response) => {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.error(error);
                    })

            },
            validateTranslation() {
                let options = {
                    headers: { 'Content-Type': 'application/json' },
                };
                ApiService.post(process.env.VUE_APP_API_URL + 'translations/'+this.$route.params.id + '/validate', options)
                    .then(() => {
                        this.$router.push({ name:'MenuPage' })
                    })
                    .catch((error) => {
                        let response = error.response;
                        if (response.status === 400) {
                            this.word.loadErrors(response.data)
                        }
                        this.busy = false;
                    })
            }
        }
    }
</script>

<style scoped>
    .word-manager-container {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        margin: 0 5%;
    }
    .submit-button-container {
        display: flex;
        flex-grow: 1;
        margin: 25px 0;
    }
    .submit-button {
        width: 100%;
    }

</style>