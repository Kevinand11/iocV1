import Vue from "vue";
import Vuetify from 'vuetify/dist/vuetify.min'
import VueCookies from "vue-cookies/vue-cookies";

import router from "./router/index";
import store from "./store/index";
import i18n from './lang/index';
import "./filters/index";
import "./dependencies";

import App from "./App.vue";

Vue.config.productionTip = true;
Vue.use(VueCookies);
Vue.use(Vuetify);

new Vue({
    router,
    store,
	i18n,
    render: h => h(App)
}).$mount("#master");
