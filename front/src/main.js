import Vue from 'vue'
import App from './App.vue'
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import router from './router.js'
import ApiService from "./services/api.service";
import {TokenService} from "./services/storage.service";
import store from './store'
import './assets/scss/main.scss';
import i18n from './i18n'
import VueMoment from 'vue-moment'

Vue.use(VueMoment);
Vue.config.productionTip = false
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

// Set the base URL of the API
ApiService.init(process.env.VUE_APP_BASE_URL);

// If token exists set header
if (TokenService.getToken()) {
  ApiService.setHeader()
}
// If 401 try to refresh token
ApiService.mount401Interceptor();

new Vue({
  router,
  store,
  i18n,
  render: h => h(App)
}).$mount('#app');
