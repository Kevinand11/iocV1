<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-header my-3">
                    <span class="card-title">Users Table</span>
                    <span class="card-tools">
                        <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                    </span>
                </div>
                <div class="card-body table-responsive p-0">
                    <user-table/>
                </div>    
            </div>
        </div>
        <user-form :form="theForm" :mode="isEdit ? 'edit' : 'create'" :isSubmitted="isSubmitted"/>
        <user-modal :user="user" />
    </div>
</template>

<script>
    import { mapGetters } from "vuex"
    import UserForm from '../../components/admin/UserForm.vue'
    import UserModal from '../../components/admin/UserModal.vue'
    import UserTable from "../../components/admin/UserTable.vue"

    export default {
        name:"Users",
        data(){
            return {
                user : {
                    id : null,
                    name : '',
                    email: '',
                    password: '',
                    phone: '',
                    store: {},
                    picture: {},
                },
                form: new Form({
                    id: null,
                    name : '',
                    email: '',
                    role: 'user',
                    phone: '',
                    password: '',
                    password_confirmation:"",
                    picture:{},
                }),
                submitted: false,
                editmode:false,
            }
        },
        computed:{
            ...mapGetters(["usersRoutes"]),
            theForm(){return this.form},
            isEdit(){return this.editmode},
            isSubmitted(){return this.submitted},
        },
        mounted(){
            Fire.$on("SetCurrentUser",(user)=>{
                this.user = user;
            });
            Fire.$on("BeforeUpdateUser",(user)=>{
                this.editModal(user)
            });
            Fire.$on("DeleteUser",(id)=>{
                this.deleteUser(id)
            });
        },
        methods:{
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#image').val('');
                $('#profile').attr('src','../img/profile.png');
                this.submitted = false;
                this.form.errors.errors = {};
                $('#form').modal('show');
            },
            editModal(user){
                this.editmode = true;
                this.form.reset();
                $('#image').val('');
                $('#profile').attr('src','../'+(!_.isEmpty(this.form.picture) ? this.picture.filename : "img/profile.png"));
                this.submitted = false;
                this.form.errors.errors = {};
                this.form.fill(user);
                $('#form').modal('show');
            },
            deleteUser(id){      
                this.form.delete(this.usersRoutes.delete +id).then((response)=>{
                    new swal('Deleted!','User deleted.','success');
                    Fire.$emit('Reload');
                }).catch(()=> {
                    new swal("Failed!", "Unable to delete. Something went wrong", "warning");
                });
            },
        },
        components:{
            "user-form" : UserForm,
            "user-modal" : UserModal,
            "user-table" : UserTable,
        }
    }
</script>
