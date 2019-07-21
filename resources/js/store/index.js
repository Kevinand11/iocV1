import Vue from "vue";
import Vuex from "vuex";
import users from "./modules/users.js";
import routeHistory from "./modules/routehistory.js";
import routes from "./modules/routes.js";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        users,
        routes,
        routeHistory
    },
})