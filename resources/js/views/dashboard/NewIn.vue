<template>
    <v-container grid-list-xs>
        <v-layout row wrap v-if="fetching">
            <v-flex xs6 offset-xs3>
                <vue-simple-spinner :message="$t('loadingSpinner')" size="large" />
            </v-flex>
        </v-layout>
        <v-layout row wrap v-if="!fetching">
            <v-flex xs12 sm6 md3 v-for="post in posts.data" :key="post.id" class="pa-1">
               <v-card  @click="viewPost(post)">
                    <v-img v-if="post.pictures" :src="post.pictures[0].filename | appendURL" height="100px" width="100px"></v-img>
                    <v-card-text primary-title>
                        <span>{{ post.name }}</span>
                        <v-spacer></v-spacer>
                        <span>{{ post.price | addNairaSign }}</span>
                    </v-card-text>
                </v-card> 
            </v-flex>
        </v-layout>
        <pagination :data="posts" align="center" :limit="limit" @pagination-change-page="getPosts" class="mt-2">
            <span slot="prev-nav"><i class="fas fa-angle-left"></i></span>
            <span slot="next-nav"><i class="fas fa-angle-right"></i></span>
        </pagination>
    </v-container>
</template>

<script>
    import { mapGetters } from "vuex"

    export default {
        name:"NewIn",
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
            this.getPosts();
        },
        computed:{
            ...mapGetters(["postsRoutes",'getLogo']),
            fetching(){return this.fetch},
        },
        methods:{
            loadPosts(url){
                this.fetch = true
                $("body").get(0).scrollIntoView();
                axios.get(url)
                .then((response)=>{
                    this.fetch = false
                    this.posts = response.data;
                }).catch(()=>{
					new toast({
						type: 'error',
						title: this.$t('cantFetchData'),
					});
                    this.fetch = false
                })
            },
            getPosts(page = 1) {
                this.loadPosts(this.postsRoutes.paginate + page);
            },
            viewPost(post){
                this.$router.push("/posts/"+post.id)
            },
        }
    }
</script>
