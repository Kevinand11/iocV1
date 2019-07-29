<template>
    <table-extend>
        <template slot="headers">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Picture</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Modifiers</th>
            </tr>
        </template>
        <template slot="rows">
            <tbody>
                <v-layout row wrap v-if="fetching">
                    <v-flex xs6 offset-xs3>
                        <vue-simple-spinner message="Loading" size="large" />
                    </v-flex>
                </v-layout>
                <tr v-for="user in users.data" :key="user.id" @click="emitCurr(user)" v-if="!fetching">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.phone}}</td>
                    <td>{{user.role}}</td>
                    <td>{{ user.picture ? user.picture.filename : 'None' }}</td>
                    <td>{{user.created_at | myDate}}</td>
                    <td>{{user.updated_at | myDate}}</td>
                    <td>
                        <a @click.prevent="viewModal(user.id)"><i class="fas fa-eye text-blue"></i></a>
                        &nbsp;|&nbsp;
                        <a @click.prevent="emitUpdate(user)"><i class="fas fa-pen text-orange"></i></a>
                        &nbsp;|&nbsp;
                        <a @click.prevent="emitDelete(user.id)"><i class="fas fa-trash text-red"></i></a>
                    </td>
                </tr>
            </tbody>
        </template>
        <template slot="pagination">
            <pagination :data="users" align="center" :limit="limit" @pagination-change-page="getUsers">
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
        name:"UserTable",
        data(){
            return {
                limit:2,
                users:{},
                fetch: false,
            }
        },
        computed:{
            ...mapGetters(["usersRoutes"]),
            fetching(){return this.fetch}
        },
        components:{
            "table-extend":TableEx,
        },
        mounted(){
            this.getUsers();
            Fire.$on('Reload',() => {
               this.getUsers();
            });
        },
        methods:{
            emitCurr(user){
                Fire.$emit("SetCurrentUser",user);
            },
            loadUsers(url){
                this.fetch = true;
                $("body").get(0).scrollIntoView();
                axios.get(url)
                .then((response)=>{
                    this.fetch = false;
                    this.users = response.data;
                }).catch(()=>{
                    new toast({
                        type: 'error',
                        title: 'Unable to fetch data'
                    });
                    this.fetch = false;
                })
            },
            getUsers(page = 1) {
                this.loadUsers(this.usersRoutes.paginate + page);
            },
            viewModal(id){
                axios.get(this.usersRoutes.show+id).then((response)=>{
                    this.user = response.data.data;
                    $('#view').modal('show');
                }).catch({});
            },
            emitUpdate(user){
                Fire.$emit("BeforeUpdateUser",user);
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
                        Fire.$emit("DeleteUser",id)
                    }
                })
            },
        }
    }
</script>
