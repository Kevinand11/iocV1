import Vue from "vue";
import Router from "vue-router/dist/vue-router.min";

import routes from './routes'

import VuexStore from "../store/index";

Vue.use(Router);

const router = new Router({
    mode: "history",
    routes
});

function isAuth() {
    let cookies = VuexStore._vm.$cookies;
    return cookies.isKey("user") && cookies.isKey("oauth");
}
function isAdmin() {
    let cookies = VuexStore._vm.$cookies;
    return cookies.isKey("user") && cookies.get("user").role === "admin";
}

let authRoutes = ['Login','Register'];
let nonGuardedRoutes = ['Login','Register','NewIn','Stores','Posts','Services','Post'];
let adminRoutes = ['AdminUsers','AdminPosts','AdminStores','AdminCategories','AdminDeveloper'];


router.beforeEach((to, from, next) => {
    if (_.includes(nonGuardedRoutes,to.name)) {
        if (_.includes(authRoutes,to.name)) {
            if(isAuth()){
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
