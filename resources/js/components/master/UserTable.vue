<template>
    <table-extend>
        <tr slot="headers">
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Password</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Modifiers</th>
        </tr>
        <tbody slot="rows">
            <tr v-for="user in users.data" :key="user.id" @click="emitCurr(user)">
                <td>{{user.id}}</td>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.role}}</td>
                <td>{{user.password}}</td>
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
        <div slot="pagination">
            <pagination :data="users" align="center" :limit="limit" @pagination-change-page="getUsers">
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
        name:"UserTable",
        data(){
            return {
                limit:2,
                users:{},
            }
        },
        components:{
            "table-extend":TableEx,
            "pagination" : Pagination,
        },
        mounted(){
            this.loadUsers();
            Fire.$on('Reload',() => {
               this.loadUsers();
            });
        },
        methods:{
            emitCurr(user){
                Fire.$emit("SetCurrentUser",user);
            },
            loadUsers(url="/api/users/paginate"){
                axios.get(url)
                .then((response)=>{
                    this.users = response.data;
                    $("nav").get(0).scrollIntoView();
                })
            },
            getUsers(page = 1) {
                this.loadUsers('/api/users/paginate?page=' + page);
            },
            viewModal(id){
                axios.get("/api/users/"+id).then((response)=>{
                    this.user = response.data;
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