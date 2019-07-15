<template>
  <div class="wrapper">
    <search-nav/>
    <panel/>
    <div class="content-wrapper">
      <div class="content py-4">
        <router-view/>
        <vue-progress-bar />
      </div>
    </div>
    <app-footer/>
  </div>
</template>

<script>
import SearchNav from "./components/SearchNav.vue"
import Panel from "./components/Panel.vue"
import Footer from "./components/Footer.vue"

export default {
  name: "App",
  components: {
    "search-nav" : SearchNav,
    "panel" : Panel,
    "app-footer" : Footer,
  },
};
</script>