import Vue from "vue";
import Router from "vue-router";

import Dashboard from "./views/Dashboard.vue";
import Developer from "./views/Developer.vue";
import Profile from "./views/Profile.vue";
import Store from "./views/Profile.vue";
import Posts from "./views/Posts.vue";
import Users from "./views/Users.vue";
import Categories from "./views/Categories.vue";
import Login from "./views/Login.vue";
import Register from "./views/Register.vue";
import NotFound from "./views/NotFound.vue";
import VuexStore from "./store/index";

Vue.use(Router);

let routes = [
    { path: '/', component: Dashboard, children: [
        { path: '/new', component: Profile }
    ]},
    { path: '/developer', component: Developer },
    { path: '/users', component: Users },
    { path: '/posts', component: Posts },
    { path: '/categories', component: Categories },
    { path: '/store', component: Store },
    { path: '/profile', component: Profile },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '*', component: NotFound }
];

const router = new Router({
    mode: "history",
    routes
});

function isAuth() {
    let cookies = VuexStore._vm.$cookies
    if(cookies.isKey("user") && cookies.isKey("oauth")){
        return true
    }
    return false
}
function isAdmin() {
    let cookies = VuexStore._vm.$cookies
    if(cookies.isKey("user") && cookies.get("user").role == "admin"){
        return true
    }
    return false
}

router.beforeEach((to, from, next) => {
    if (to.path == "/login" || to.path == "/register") {
        if (!isAuth()) {
            next();
        } else {
            new toast({
                type: 'warning',
                title: 'User already logged in'
            });
            next(VuexStore.getters.getLastNonAuthRoute);
        }
    } else {
        if (!isAuth()) {
            new toast({
                type: 'error',
                title: 'Login To Continue'
            });
            VuexStore.dispatch("setIntended",to.path);
            next("/login");
        } else {
            if(to.path == "/users" || to.path == "/posts" || to.path == "/categories" || to.path == "/developer"){
                if(isAdmin()){
                    next()
                }else{
                    new toast({
                        type: 'error',
                        title: 'Access deneid. Unauthorised user'
                    });
                    next(VuexStore.getters.getLastNonAuthRoute);
                }
            }else{
                next();
            }
        }
    }
})

router.afterEach( route => {
    VuexStore.dispatch("appendHistory",route.path);
})

export default router;