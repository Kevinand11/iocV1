<template>
    <div>
        <nav class="main-header navbar navbar-expand-sm bg-dark navbar-dark border-bottom">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
            </ul>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link">New</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="#" class="nav-link">Stores</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="#" class="nav-link">Promotions</router-link>
                    </li>
                    <!-- <span class="input-group input-group-sm">
                        <input class="form-inline form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
                        <span class="input-group-append">
                        <button class="btn btn-navbar" @click="searchit">
                            <i class="fa fa-search"></i>
                        </button>
                        </span>
                    </span> -->
                    <!-- <form class="form-inline">
                        <span class="input-group input-group-sm">
                            <input class="form-inline form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
                            <span class="input-group-append">
                            <button class="btn btn-navbar" @click="searchit">
                                <i class="fa fa-search"></i>
                            </button>
                            </span>
                        </span>
                    </form> -->
                </ul>
                <a class="navbar-brand" href="" @click.prevent>IOCMart</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <!-- <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                    </li>
                </ul>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">New</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="#" class="nav-link">Stores</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="#" class="nav-link">Promotions</router-link>
                        </li>
                        <span class="input-group input-group-sm">
                            <input class="form-inline form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
                            <span class="input-group-append">
                            <button class="btn btn-navbar" @click="searchit">
                                <i class="fa fa-search"></i>
                            </button>
                            </span>
                        </span>
                    </ul>
                </div>
                
                <a class="navbar-brand" href="" @click.prevent>IOCMart</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav> -->
    </div>
</template>

<script>
export default {
    name:"SearchNav",
    data(){
        return {
            search: "",
        }
    },
    methods:{
        searchit:()=>{
            console.log("Searching");
        },
    }
}
</script>