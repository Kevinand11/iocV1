import Vue from "vue";
import Vuex from "vuex";

import app from './modules/appInfo'
import auth from "./modules/auth";
import history from "./modules/history";
import routes from "./modules/routes";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        app,
        auth,
        routes,
        history,
    },
})
