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
import Stores from "./views/Admin/Stores.vue";
import Categories from "./views/Admin/Categories.vue";

import Login from "./views/Auth/Login.vue";
import Register from "./views/Auth/Register.vue";

import VuexStore from "./store/index";

Vue.use(Router);

let routes = [
    { path: '/', component: Dashboard, children: [
        { path: '/', name: 'NewIn',component: NewIn },
        { path: '/stores', name: 'Stores', component: Store },
        { path: '/services', name: 'Services', component: Store },
        { path: '/posts/', name: 'Posts', component: NewIn },
        { path: '/posts/:id', name: 'Post', component: Post },
        { path: '/stores/:id', name: 'Store', component: Post },
        { path: '/services/:id', name: 'Service', component: Post },
    ]},
    { path: '/admin/developer', name: 'AdminDeveloper', component: Developer },
    { path: '/admin/users', name: 'AdminUsers', component: Users },
    { path: '/admin/stores', name: 'AdminStores', component: Stores },
    { path: '/admin/posts', name: 'AdminPosts', component: Posts },
    { path: '/admin/categories', name: 'AdminCategories', component: Categories },
    { path: '/store', name: 'MyStore', component: Store },
    { path: '/profile', name: 'Profile', component: Profile },
    { path: '/login', name: 'Login', component: Login },
    { path: '/register', name: 'Register', component: Register },
    { path: '*', name: 'NotFound', component: NotFound }
];

const router = new Router({
    mode: "history",
    routes
});

function isAuth() {
    let cookies = VuexStore._vm.$cookies;
    return (cookies.isKey("user") && cookies.isKey("oauth"));
}
function isAdmin() {
    let cookies = VuexStore._vm.$cookies;
    return (cookies.isKey("user") && cookies.get("user").role === "admin");
}

let authRoutes = ['Login','Register'];
let nonGuardedRoutes = ['Login','Register','NewIn','Stores','Posts','Services','Post','Store','Service'];
let adminRoutes = ['AdminUsers','AdminPosts','AdminStores','AdminCategories','AdminDeveloper'];


router.beforeEach((to, from, next) => {
    if (_.includes(nonGuardedRoutes,to.name)) {
        if (_.includes(authRoutes,to.name)) {
            if(!isAuth()){
                new toast({
                    type: 'warning',
                    title: 'User already logged in'
                });
                next(VuexStore.getters.getLastNonAuthRoute);
            }
            next();
        } else {
            next()
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
            if(_.includes(adminRoutes,to.name)){
                if(isAdmin()){
                    next()
                }else{
                    new toast({
                        type: 'error',
                        title: 'Access denied. Unauthorised user'
                    });
                    next(VuexStore.getters.getLastNonAuthRoute);
                }
            }else{
                next();
            }
        }
    }
});

router.afterEach( route => {
    VuexStore.dispatch("appendHistory",route.path);
});

export default router;
