import Vue from "vue";
import Router from "vue-router";

import Dashboard from "./views/Dashboard/index.vue";
import NewIn from "./views/Dashboard/NewIn.vue";
import Post from "./views/Dashboard/Post.vue";

import Profile from "./views/Profile.vue";
import Store from "./views/Store.vue";
import NotFound from "./views/NotFound.vue";

import Developer from "./views/Admin/Developer.vue";
import Posts from "./views/Admin/Posts.vue";
import Users from "./views/Admin/Users.vue";
import Categories from "./views/Admin/Categories.vue";

import Login from "./views/Auth/Login.vue";
import Register from "./views/Auth/Register.vue";

import VuexStore from "./store/index";

Vue.use(Router);

let routes = [
    { path: '/', component: Dashboard, children: [
        { path: '/', component: NewIn },
        { path: '/stores', component: Store },
        { path: '/trending', component: Store },
        { path: '/services', component: Store },
        { path: '/posts/', component: NewIn },
        { path: '/posts/:id', component: Post },
    ]},
    { path: '/admin/developer', component: Developer },
    { path: '/admin/users', component: Users },
    { path: '/admin/posts', component: Posts },
    { path: '/admin/categories', component: Categories },
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