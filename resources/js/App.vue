<template>
    <v-app>
        <app-toolbar />
        <app-sidebar />
        <v-content>
            <router-view />
            <vue-progress-bar />
        </v-content>
        <app-footer />
    </v-app>
</template>

<script>
import Toolbar from "./components/Toolbar.vue"
import Sidebar from "./components/Sidebar.vue"
import Footer from "./components/Footer.vue"
import { mapActions } from "vuex"

export default {
    name: "App",
    components: {
        "app-toolbar" : Toolbar,
        "app-sidebar" : Sidebar,
        "app-footer" : Footer,
    },
    mounted(){
        this.getCookieToken();
    },
    methods:{
        ...mapActions(["setAuth","setToken"]),
        getCookieToken(){
            if(this.$cookies.isKey("oauth") && this.$cookies.isKey("user")){
                this.setToken(this.$cookies.get("oauth"));
                this.setAuth(this.$cookies.get("user"));
            }
        }
    }
};
</script>