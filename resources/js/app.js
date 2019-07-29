import Vue from "vue";
import Vuetify from 'vuetify'
import VueCookies from "vue-cookies";

import router from "./router/index";
import store from "./store/index";
import "./filters/index";
import "./dependencies";

import { mapGetters } from "vuex";

import App from "./App.vue";

Vue.config.productionTip = true;
Vue.use(VueCookies);
Vue.use(Vuetify);

new Vue({
    router,
    store,
    computed:{
        ...mapGetters(["getToken"]),
    },
    watch:{
        getToken(){
            window.axios.defaults.headers.common['Authorization'] = "Bearer " + this.getToken;
        }
    },
    render: h => h(App)
}).$mount("#master");
