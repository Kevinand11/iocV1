<template>
    <table-extend>
        <tr slot="headers">
            <th>Id</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Poster</th>
            <th>Category</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Modifiers</th>
        </tr>
        <tbody slot="rows">
            <vue-simple-spinner message="Loading" size="big" v-if="fetching" class="text-center" />
            <tr v-for="post in posts.data" :key="post.id" @click="emitCurr(post)" v-if="!fetching">
                <td>{{post.id}}</td>
                <td>{{post.name}}</td>
                <td>{{post.description | first100}}</td>
                <td>{{post.price | addNairaSign}}</td>
                <td>{{post.user.name}}</td>
                <td>{{post.category.name}}</td>
                <td>{{post.created_at | myDate}}</td>
                <td>{{post.updated_at | myDate}}</td>
                <td>
                    <a @click.prevent="viewModal(post.id)"><i class="fas fa-eye text-blue"></i></a>
                    &nbsp;|&nbsp;
                    <a @click.prevent="emitUpdate(post)"><i class="fas fa-pen text-orange"></i></a>
                    &nbsp;|&nbsp;
                    <a @click.prevent="emitDelete(post.id)"><i class="fas fa-trash text-red"></i></a>
                </td>
            </tr>
        </tbody>
        <div slot="pagination">
            <pagination :data="posts" align="center" :limit="limit" @pagination-change-page="getPosts">
                <span slot="prev-nav"><i class="fas fa-angle-left"></i></span>
                <span slot="next-nav"><i class="fas fa-angle-right"></i></span>
            </pagination>
        </div>
    </table-extend>
</template>

<script>
    import { mapGetters } from "vuex"
    import TableEx from "../Table.vue"

    export default {
        name:"PostTable",
        data(){
            return {
                limit:2,
                posts:{},
                fetch:false,
            }
        },
        computed:{
            ...mapGetters(["postsRoutes"]),
            fetching(){return this.fetch}
        },
        components:{
            "table-extend":TableEx,
        },
        mounted(){
            this.getPosts();
            Fire.$on('Reload',() => {
               this.getPosts();
            });
        },
        methods:{
            emitCurr(post){
                Fire.$emit("SetCurrentPost",post);
            },
            loadPosts(url){
                this.fetch = true;
                $("body").get(0).scrollIntoView();
                axios.get(url)
                .then((response)=>{
                    this.fetch = false;
                    this.posts = response.data;
                }).catch(error=>{
                    this.fetch = false;
                })
            },
            getPosts(page = 1) {
                this.loadPosts(this.postsRoutes.paginate + page);
            },
            viewModal(id){
                axios.get(this.postsRoutes.show+id).then((response)=>{
                    this.post = response.data.data;
                    $('#view').modal('show');
                }).catch({});
            },
            emitUpdate(post){
                Fire.$emit("BeforeUpdatePost",post);
            },
            emitDelete(id){
                new swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        Fire.$emit("DeletePost",id)
                    }
                })
            },
        }
    }
</script>
