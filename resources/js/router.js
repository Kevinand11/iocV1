import Vue from "vue";
import Router from "vue-router";

import Dashboard from "./views/Dashboard.vue";
import Developer from "./views/Developer.vue";
import Profile from "./views/Profile.vue";
import Posts from "./views/Posts.vue";
import Users from "./views/Users.vue";
import Categories from "./views/Categories.vue";
import NotFound from "./views/NotFound.vue";

Vue.use(Router);

let routes = [
    { path: '/master/', component: Dashboard },
    { path: '/master/developer', component: Developer },
    { path: '/master/users', component: Users },
    { path: '/master/posts', component: Posts },
    { path: '/master/categories', component: Categories },
    { path: '/master/profile', component: Profile },
    { path: '*', component: NotFound }
];

const router = new Router({
    mode: "history",
    routes
});

/* router.beforeEach((to, from, next) => {
    if (to.path == "/login" || to.path == "/signup") {
        if (Store.getters.getAuth.name == "") {
            next();
        } else {
            next("/home");
        }
    } else {
        if (Store.getters.getAuth.name == "") {
            next("/login");
        } else {
            next();
        }
    }
}) */

export default router;