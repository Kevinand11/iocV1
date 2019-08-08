<template>
    <table-extend>
        <template slot="headers">
            <tr>
                <th>{{ $t('postTableId') }}</th>
                <th>{{ $t('postTableName') }}</th>
                <th>{{ $t('postTableDescription') }}</th>
                <th>{{ $t('postTablePrice') }}</th>
                <th>{{ $t('postTablePostedBy') }}</th>
                <th>{{ $t('postTableCategory') }}</th>
                <th>{{ $t('postTablePictures') }}</th>
                <th>{{ $t('postTableCreated') }}</th>
                <th>{{ $t('postTableUpdated') }}</th>
                <th>{{ $t('postTableModifiers') }}</th>
            </tr>
        </template>
        <template slot="rows">
            <tbody>
                <v-layout row wrap v-if="fetching">
                    <v-flex xs6 offset-xs3>
                        <vue-simple-spinner :message="$t('loadingSpinner')" size="large" />
                    </v-flex>
                </v-layout>
                <tr v-for="post in posts.data" :key="post.id" @click="emitCurr(post)" v-if="!fetching">
                    <td>{{post.id}}</td>
                    <td>{{post.name}}</td>
                    <td>{{post.description | first100}}</td>
                    <td>{{post.price | addNairaSign}}</td>
                    <td>{{post.store.name}}</td>
                    <td>{{post.category.name}}</td>
                    <td>
                        <span v-for="picture in post.pictures">{{picture.filename}},</span>
                    </td>
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
        </template>
        <template slot="pagination">
            <pagination :data="posts" align="center" :limit="limit" @pagination-change-page="getPosts">
                <span slot="prev-nav"><i class="fas fa-angle-left"></i></span>
                <span slot="next-nav"><i class="fas fa-angle-right"></i></span>
            </pagination>
        </template>
    </table-extend>
</template>

<script>
    import { mapGetters } from "vuex"
    import TableEx from "./extensions/Table.vue"

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
            Fire.$on('ReloadPosts',() => {
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
                }).catch(()=>{
                    new toast({
                        type: 'error',
                        title: this.$t('postTableError'),
                    });
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
                    title: this.$t('deleteConfirmTitle'),
                    text: this.$t('deleteConfirmText'),
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: this.$t('deleteConfirmButton')
                }).then((result) => {
                    if (result.value) {
                        Fire.$emit("DeletePost",id)
                    }
                })
            },
        }
    }
</script>
