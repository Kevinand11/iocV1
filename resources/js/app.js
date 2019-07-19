import Vue from "vue";
import Vuetify from 'vuetify'
import VueCookies from "vue-cookies";

import router from "./router";
import store from "./store/index";
import "./filters/index";
import "./dependencies"

import App from "./App.vue";
import { mapGetters,mapActions } from "vuex"

Vue.config.productionTip = true;
Vue.use(VueCookies);
Vue.use(Vuetify)

new Vue({
    router,
    store,
    computed:{
        ...mapGetters(["getToken"])
    },
    watch:{
        getToken(){
            if (this.getToken) {
                window.axios.defaults.headers.common['Authorization'] = "Bearer " + this.getToken;
            } else {
                window.axios.defaults.headers.common['Authorization'] = null;
            }
        }
    },
    render: h => h(App)
}).$mount("#master");