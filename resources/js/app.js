import Vue from "vue";
import Vuetify from 'vuetify'
import VueCookies from "vue-cookies";

import router from "./router/index";
import store from "./store/index";
import "./filters/index";
import "./dependencies";

import App from "./App.vue";

Vue.config.productionTip = true;
Vue.use(VueCookies);
Vue.use(Vuetify);

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#master");
