<template>
    <div class="container">
        <router-view></router-view>
        <!-- <div class="row justify-content-center">
            <vue-simple-spinner message="Loading" size="big" v-if="fetching" class="text-center" />
            <div class="card-group">
                <div class="col-md-6" v-for="curr in posts.data":key="curr.id" @click="viewModal(curr)">
                    <div class="card">
                        <div class="card-header">
                            <img src="../img/logo.png" class="card-img-top" />
                        </div>
                        <div class="card-body">
                            <span class="lead">{{curr.name}}</span>
                            <span class="float-right">{{curr.price | addNairaSign}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <pagination :data="posts" align="center" :limit="limit" @pagination-change-page="getPosts">
                <span slot="prev-nav"><i class="fas fa-angle-left"></i></span>
                <span slot="next-nav"><i class="fas fa-angle-right"></i></span>
            </pagination>
        </div>
        <post-modal :post="post"/> -->
    </div>
</template>

<script>
    import PostModal from "../components/master/PostModal.vue"
    import { mapActions,mapGetters } from "vuex"

    export default {
        name:"Dashboard",
        data(){
            return {
                limit:2,
                posts: {},
                post : {
                    id : null,
                    name : '',
                    description: '',
                    price: '',
                    user_id: null,
                    category: {},
                    user: {}
                },
                categories:[],
                fetch:false,
            }
        },
        mounted(){
            this.loadPosts();
            this.getCategories("/api/categories/");
        },
        computed:{
            ...mapGetters(['getHistory',"getLastRoute","getLastNonAuthRoute"]),
            fetching(){return this.fetch}
        },
        methods:{
            loadPosts(url="/api/posts/paginate"){
                this.fetch = true
                axios.get(url)
                .then((response)=>{
                    this.fetch = false
                    this.posts = response.data;
                    $("nav").get(0).scrollIntoView();
                }).catch(error=>{
                    this.fetch = false
                })
            },
            getCategories(url){
                axios.get(url).then((response)=>{
                    this.categories = response.data;
                })
            },
            getPosts(page = 1) {
                this.loadPosts('/api/posts/paginate?page=' + page);
            },
            viewModal(post){
                this.post = post;
                $('#view').modal('show');
            },
        },
        components:{
            "post-modal" : PostModal,
        }
    }
</script>
