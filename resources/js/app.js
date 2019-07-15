import Vue from "vue";
import VueSession from "vue-session";
import App from "./App.vue";
import router from "./router";
import "./filters/index";
import store from "./store/index";

import "./dependencies"

Vue.config.productionTip = false;
Vue.use(VueSession);

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#master");