<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-header my-3">
                    <h3 class="card-title">Posts Table</h3>
                    <div class="card-tools">
                        <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-cart-plus fa-fw"></i></button>
                    </div>
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
    import PostTable from '../components/master/PostTable.vue'
    import PostForm from '../components/master/PostForm.vue'
    import PostModal from '../components/master/PostModal.vue'

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
                    user: {}
                },
                form: new Form({
                    id : null,
                    name : '',
                    description: '',
                    price: '',
                    user_id: null,
                    category_id: null,
                }),
                submitted: false,
                editmode:false,
            }
        },
        computed:{
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
                this.form.delete('/api/posts/'+id).then((response)=>{
                    new swal('Deleted!','Post deleted.','success');
                    Fire.$emit('Reload');
                }).catch(()=> {
                    new swal("Failed!", "Unable to delete. Something went wrong", "warning");
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
