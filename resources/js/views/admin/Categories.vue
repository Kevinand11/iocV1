<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-header my-3">
                    <h3 class="card-title">Categories Table</h3>
                    <div class="card-tools">
                        <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-plus-square fa-fw"></i></button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <category-table />
                </div>
            </div>
        </div>
        <category-form :form="theForm" :mode="isEdit ? 'edit' : 'create'" :isSubmitted="isSubmitted"/>
        <category-modal :category="category"/>
    </div>
</template>

<script>
    import { mapGetters } from "vuex"
    import CategoryTable from "../../components/admin/CategoryTable.vue"
    import CategoryForm from '../../components/admin/CategoryForm.vue'
    import CategoryModal from '../../components/admin/CategoryModal.vue'

    export default {
        name:"Categories",
        data(){
            return {
                category : {
                    id : null,
                    name : '',
                    parent: '',
                    posts: []
                },
                form: new Form({
                    id : null,
                    name : '',
                    parent: 'None',
                    posts: {},
                }),
                submitted: false,
                editmode:false,
            }
        },
        computed:{
            ...mapGetters(["categoriesRoutes"]),
            theForm(){return this.form},
            isEdit(){return this.editmode},
            isSubmitted(){return this.submitted},
        },
        mounted(){
            Fire.$on("SetCurrentCategory",(category)=>{
                this.category = category;
            });
            Fire.$on("BeforeUpdateCategory",(category)=>{
                this.editModal(category)
            });
            Fire.$on("DeleteCategory",(id)=>{
                this.deleteCategory(id)
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
            editModal(category){
                this.editmode = true;
                this.form.reset();
                this.submitted = false;
                this.form.errors.errors = {};
                this.form.fill(category);
                $('#form').modal('show');
            },
            deleteCategory(id){
                this.form.delete(this.categoriesRoutes.delete +id).then((response)=>{
                    new swal('Deleted!','Category deleted.','success');
                    Fire.$emit('Reload');
                }).catch(()=> {
                    new swal("Failed!", "Unable to delete. Something went wrong", "warning");
                });
            },
        },
        components:{
            "category-table" : CategoryTable,
            "category-form" : CategoryForm,
            "category-modal" : CategoryModal,
        }
    }
</script>

