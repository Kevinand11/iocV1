<template>
    <v-toolbar app color="light-blue darken-4" dark class="horizontal-scroll">
        <v-toolbar-side-icon  @click.stop="emitToggle" class=""></v-toolbar-side-icon>
        <v-list-tile-avatar>
            <img src="../img/logo.png">
        </v-list-tile-avatar>
        <v-toolbar-title class="white--text hidden-xs-only">IOCMart</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            <v-btn flat icon :to="navlink.route" v-for="navlink in navlinks" :key="navlink.id" class="">
                <!-- <span>{{navlink.name}}</span> -->
                <v-icon :color="navlink.color">{{navlink.icon}}</v-icon>
            </v-btn>
            <!-- <v-text-field  width="50px" append-icon="search" placeholder="Search" clearable @click:append="searchIt" v-model="search"></v-text-field> -->
        </v-toolbar-items>
    </v-toolbar>
</template>

<script>
    export default {
        name: "Toolbar",
        data(){
            return {
                search: "",
                navlinks:[
                    {id:51, name:'Trending', icon:'local_offer', route:'/trending', color:"white"},
                    {id:52, name:'New In', icon:'new_releases', route:'/', color:"white"},
                    {id:53, name:'Store', icon:'shop_two', route:'/stores', color:"white"},
                    {id:54, name:'Services', icon:'event', route:'/services', color:"white"},
                ],
            }
        },
        methods:{
            searchIt(){
                console.log(this.search)
            },
            emitToggle(){
                Fire.$emit("ToggleSidebar");
            }
        },
    }
</script>
