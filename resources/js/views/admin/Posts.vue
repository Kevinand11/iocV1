<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-header my-3">
                    <span class="card-title">{{ $t('postTableHeader') }}</span>
                    <button class="btn btn-success" @click="newModal">{{ $t('addNewButton') }}<i class="fas fa-cart-plus fa-fw"></i></button>
                </div>
                <div class="card-body table-responsive p-0">
                    <post-table/>
                </div>
            </div>
        </div>
        <post-form :form="theForm" :mode="isEdit ? 'edit' : 'create'" :isSubmitted="isSubmitted" />
        <post-modal :post="post"/>
    </div>
</template>

<script>
    import { mapGetters } from "vuex"
    import PostTable from '../../components/admin/PostTable.vue'
    import PostForm from '../../components/admin/PostForm.vue'
    import PostModal from '../../components/admin/PostModal.vue'

    export default {
        name:"Posts",
        data(){
            return {
                post : {
                    id : null,
                    name : '',
                    description: '',
                    price: '',
                    category: {},
                    store: {user:{},phone:{}},
                    pictures: [],
                    category_id: null,
                    created_at: {},
                    updated_at: {},
                },
                form: new Form({
                    id: null,
                    name : '',
                    description: '',
                    price: '',
                    category_id: 1,
                }),
                submitted: false,
                editmode:false,
            }
        },
        computed:{
            ...mapGetters(["postsRoutes"]),
            theForm(){return this.form},
            isEdit(){return this.editmode},
            isSubmitted(){return this.submitted},
        },
        mounted(){
            Fire.$on("SetCurrentPost",(post)=>{
                this.post = post;
            });
            Fire.$on("BeforeUpdatePost",(post)=>{
                this.editModal(post)
            });
            Fire.$on("DeletePost",(id)=>{
                this.deletePost(id)
            });
        },
        methods:{
            newModal(){
                this.editmode = false;
                this.form.reset();
                this.submitted = false;
                this.form.errors.errors = {};
                $('#form').modal('show');
            },
            editModal(post){
                this.editmode = true;
                this.form.reset();
                this.submitted = false;
                this.form.errors.errors = {};
                this.form.fill(post);
                $('#form').modal('show');
            },
            deletePost(id){
                this.form.delete(this.postsRoutes.delete+id).then((response)=>{
                    new swal(this.$t('deleted'),this.$t('postDeleted'),'success');
                    Fire.$emit('ReloadPosts');
                }).catch(()=> {
                    new swal(this.$t('failed'), this.$t('failedDelete'), "warning");
                });
            },
        },
        components:{
            "post-table" : PostTable,
            "post-form" : PostForm,
            "post-modal" : PostModal,
        }
    }
</script>
