import Vue from "vue";
import Vuex from "vuex";
import auth from "./modules/auth.js";
import history from "./modules/history.js";
import routes from "./modules/routes.js";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        routes,
        history
    },
})