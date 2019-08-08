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

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
		if (isAuth()) {
			if(to.meta.requiresAdmin){
				if(isAdmin()){
					next()
				}else{
					new toast({
						type: 'error',
						title: VuexStore._vm.$t('routeUnauthorized')
					});
					next(VuexStore.getters.getLastNonAuthRoute);
				}
			}else{
				next();
			}
		} else {
			VuexStore.dispatch("setIntended",to.path);
			new toast({
				type: 'error',
				title: VuexStore._vm.$t('routeMustLogin')
			});
			next("/login");
		}
    } else {
		if (to.meta.isAuthRoute) {
			if(isAuth()){
				new toast({
					type: 'warning',
					title: VuexStore._vm.$t('routeAlreadyLoggedIn')
				});
				next(VuexStore.getters.getLastNonAuthRoute);
			}
			next();
		} else {
			next()
		}
    }
});

router.afterEach( route => {
    VuexStore.dispatch("appendHistory",route.path);
});

export default router;
