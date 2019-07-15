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
            <tr v-for="post in posts.data" :key="post.id" @click="emitCurr(post)">
                <td>{{post.id}}</td>
                <td>{{post.name}}</td>
                <td>{{post.description | first100}}</td>
                <td>{{post.price | addNairaSign}}</td>
                <td>{{post.user.name}}</td>
                <td>{{post.category.name}}</td>
                <td>{{post.created_at | myDate}}</td>
                <td>{{post.updated_at | myDate}}</td>
                <td>
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
    import TableEx from "../Table.vue"
    import Pagination from 'laravel-vue-pagination'

    export default {
        name:"PostTable",
        data(){
            return {
                limit:2,
                posts:{},
            }
        },
        components:{
            "table-extend":TableEx,
            "pagination" : Pagination,
        },
        mounted(){
            this.loadPosts();
            Fire.$on('Reload',() => {
               this.loadPosts();
            });
        },
        methods:{
            emitCurr(post){
                Fire.$emit("SetCurrentPost",post);
            },
            loadPosts(url="/api/posts/paginate"){
                axios.get(url)
                .then((response)=>{
                    this.posts = response.data;
                    $("nav").get(0).scrollIntoView();
                })
            },
            getPosts(page = 1) {
                this.loadPosts('/api/posts/paginate?page=' + page);
            },
            viewModal(id){
                axios.get("/api/posts/"+id).then((response)=>{
                    this.post = response.data;
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