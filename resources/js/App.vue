<template>
    <v-app>
        <app-toolbar />
        <app-sidebar />
        <v-content>
            <v-container fluid>
                <router-view />
                <vue-progress-bar />
                <v-btn fab color="light-blue darken-4" bottom right fixed @click="cartFab" v-if="isLoggedIn">
                    <v-icon color="white">shopping_cart</v-icon>
                </v-btn>
            </v-container>
        </v-content>
        <app-footer />
    </v-app>
</template>

<script>
import Toolbar from "./components/app/Toolbar";
import Sidebar from "./components/app/Sidebar";
import Footer from "./components/app/Footer";
import { mapGetters,mapActions } from "vuex";

export default {
  name: "App",
  components: {
    "app-sidebar": Sidebar,
    "app-toolbar": Toolbar,
    "app-footer": Footer
  },
  beforeMount() {
    this.getCookieToken();
  },
  computed: {
    ...mapGetters(["getAuth","authRoutes",'isLoggedIn']),
  },
  methods: {
    ...mapActions(["setAuth", "setToken","logout"]),
    getCookieToken() {
      if (this.$cookies.isKey("oauth") && this.$cookies.isKey("user")) {
        this.setToken({token:this.$cookies.get("oauth"),remember:true});
        this.setAuth({user:this.$cookies.get("user"),remember:true});
        axios.get(this.authRoutes.profile).then(response=>{
            this.setAuth({user:response.data.data,remember:true});
        }).catch(()=>{
            new toast({
                type : 'error',
                title: 'Failed to login automatically'
            });
            this.logout();
        });
      }
    },
    cartFab(){
      console.log("Going To Cart!")
    }
  }
};
</script>
