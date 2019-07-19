import Vue from "vue";
import Vuex from "vuex";
import users from "./modules/users.js";
import routes from "./modules/routehistory.js";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        users,
        routes
    },
})