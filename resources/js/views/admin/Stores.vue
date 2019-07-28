<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-header my-3">
                    <span class="card-title">Stores Table</span>
                    <span class="card-tools">
                        <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-plus fa-fw"></i></button>
                    </span>
                </div>
                <div class="card-body table-responsive p-0">
                    <store-table/>
                </div>
            </div>
        </div>
        <store-form :form="theForm" :mode="isEdit ? 'edit' : 'create'" :isSubmitted="isSubmitted"/>
        <store-modal :store="store" />
    </div>
</template>

<script>
    import { mapGetters } from "vuex"
    import StoreForm from '../../components/admin/StoreForm.vue'
    import StoreModal from '../../components/admin/StoreModal.vue'
    import StoreTable from "../../components/admin/StoreTable.vue"

    export default {
        name:"Stores",
        data(){
            return {
                store : {
                    id : null,
                    name : '',
                    email: '',
                    link: '',
                    phone: '',
                    description: '',
                    posts: [],
                    picture: {},
                    user: {},
                },
                form: new Form({
                    id : null,
                    name : '',
                    email: '',
                    link: '',
                    phone: '',
                    description: '',
                    picture:'',
                }),
                submitted: false,
                editmode:false,
            }
        },
        computed:{
            ...mapGetters(["storesRoutes"]),
            theForm(){return this.form},
            isEdit(){return this.editmode},
            isSubmitted(){return this.submitted},
        },
        mounted(){
            Fire.$on("SetCurrentStore",(store)=>{
                this.store = store;
            });
            Fire.$on("BeforeUpdateStore",(store)=>{
                this.editModal(store)
            });
            Fire.$on("DeleteStore",(id)=>{
                this.deleteStore(id)
            });
        },
        methods:{
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#image').val('');
                $('#profile').attr('src','../img/store.png');
                this.submitted = false;
                this.form.errors.errors = {};
                $('#form').modal('show');
            },
            editModal(store){
                this.editmode = true;
                this.form.reset();
                $('#image').val('');
                $('#profile').attr('src','../'+(!_.isEmpty(this.form.picture) ? this.picture.filename : "img/store.png"));
                this.submitted = false;
                this.form.errors.errors = {};
                this.form.fill(store);
                $('#form').modal('show');
            },
            deleteStore(id){
                this.form.delete(this.storesRoutes.delete +id).then((response)=>{
                    new swal('Deleted!','Store deleted.','success');
                    Fire.$emit('Reload');
                }).catch(()=> {
                    new swal("Failed!", "Unable to delete. Something went wrong", "warning");
                });
            },
        },
        components:{
            "store-form" : StoreForm,
            "store-modal" : StoreModal,
            "store-table" : StoreTable,
        }
    }
</script>
