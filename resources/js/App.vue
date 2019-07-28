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
import Toolbar from "./components/Toolbar";
import Sidebar from "./components/Sidebar";
import Footer from "./components/Footer";
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
    ...mapGetters(["getAuth"]),
    isLoggedIn(){ return this.getAuth.name !== "" }
  },
  methods: {
    ...mapActions(["setAuth", "setToken"]),
    getCookieToken() {
      if (this.$cookies.isKey("oauth") && this.$cookies.isKey("user")) {
        this.setToken(this.$cookies.get("oauth"));
        this.setAuth(this.$cookies.get("user"));
      }
    },
    cartFab(){
      console.log("Going To Cart!")
    }
  }
};
</script>
