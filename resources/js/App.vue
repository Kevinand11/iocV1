<template>
    <v-app>
        <app-toolbar />
        <app-sidebar />
        <v-content>
            <v-container fluid>
				<vue-progress-bar />
				<router-view />
				<app-fab></app-fab>
			</v-container>
        </v-content>
        <app-footer />
    </v-app>
</template>

<script>
	import Toolbar from "./components/app/Toolbar";
	import Sidebar from "./components/app/Sidebar";
	import Footer from "./components/app/Footer";
	import FloatingButton from './components/app/FloatingButton'
	import { mapGetters,mapActions } from "vuex";

	export default {
		name: "App",
		components: {
			"app-sidebar": Sidebar,
			"app-toolbar": Toolbar,
			"app-footer": Footer,
			"app-fab": FloatingButton,
		},
		beforeMount() {
			this.loginUserAutomatically();
		},
		computed: {
			...mapGetters(["authRoutes"]),
		},
		methods: {
			...mapActions(["setAuth", "setToken","logout"]),
			loginUserAutomatically() {
				if (this.$cookies.isKey("oauth") && this.$cookies.isKey("user")) {
					this.setToken({token:this.$cookies.get("oauth"),remember:true});
					this.setAuth({user:this.$cookies.get("user"),remember:true});
					axios.get(this.authRoutes.profile).then(response=>{
						this.setAuth({user:response.data.data,remember:true});
					}).catch(()=>{
						new toast({
							type : 'error',
							title: this.$t('automaticLoginError')
						});
						this.logout();
					});
				}
			},
		}
	};
</script>
