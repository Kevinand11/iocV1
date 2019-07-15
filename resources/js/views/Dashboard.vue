<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card-group">
                <div class="col-md-6" v-for="curr in posts.data":key="curr.id" @click="viewModal(curr)">
                    <div class="card">
                        <div class="card-header">
                            <span class="lead">{{curr.name}}</span>
                            <span class="float-right">{{curr.price | addNairaSign}}</span>
                        </div>
                        <div class="card-body">
                            <p>{{curr.description | first100}}</p><hr>
                        </div>
                    </div>
                </div>
            </div>
            <pagination :data="posts" align="center" :limit="limit" @pagination-change-page="getPosts">
                    <span slot="prev-nav"><i class="fas fa-angle-left"></i></span>
                    <span slot="next-nav"><i class="fas fa-angle-right"></i></span>
                </pagination>
        </div>
        <post-modal :post="post"/>
    </div>
</template>

<script>
    import Pagination from 'laravel-vue-pagination'
    import PostModal from "../components/master/PostModal.vue"

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
            }
        },
        mounted(){
            this.loadPosts();
            this.getCategories("/api/categories/");
        },
        methods:{
            loadPosts(url="/api/posts/paginate"){
                axios.get(url)
                .then((response)=>{
                    this.posts = response.data;
                    $("nav").get(0).scrollIntoView();
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
            "pagination" : Pagination,
            "post-modal" : PostModal,
        }
    }
</script>
