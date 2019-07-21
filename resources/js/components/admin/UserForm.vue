<template>
    <form-extend data-name="User" :mode="mode">
        <div slot="inputFields">
            <div class="form-group">
                <input v-model="form.name" type="text" name="name" placeholder="Name" autocomplete="name"
                    class="form-control" :class="{ 'is-valid': !form.errors.has('name') && isSubmitted,'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
            </div>
            <div class="form-group">
                <input v-model="form.email" name="email" type="email" placeholder="Email" autocomplete="email"
                class="form-control" :class="{ 'is-valid': !form.errors.has('email') && isSubmitted,'is-invalid': form.errors.has('email') }">
                <has-error :form="form" field="email"></has-error>
            </div>
            <div class="form-group">
                <select v-model="form.role" name="role" class="form-control">
                    <option value="user">user</option>
                    <option value="admin">admin</option>
                </select>
                <has-error :form="form" field="category_id"></has-error>
            </div>
            <div class="form-group">
                <input v-model="form.password" type="password" name="password" placeholder="Password" autocomplete="password"
                    class="form-control" :class="{ 'is-valid': !form.errors.has('password') && isSubmitted,'is-invalid': form.errors.has('password') }">
                <has-error :form="form" field="password"></has-error>
            </div>
            <div class="form-group">
                <input v-model="form.password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" autocomplete="password_confirmation"
                    class="form-control" :class="{ 'is-valid': !form.errors.has('password_confirmation') && isSubmitted,'is-invalid': form.errors.has('password_confirmation') }">
                <has-error :form="form" field="password_confirmation"></has-error>
            </div>
        </div>
    </form-extend>
</template>

<script>
    import { mapGetters } from "vuex"
    import FormEx from "../Form.vue"

    export default {
        name:"UserForm",
        props:{
            "form":{
                type:Object,
                required:true
            },
            "mode":{
                type:String,
                required:true
            },
            "isSubmitted":{
                type:Boolean,
                required:true
            }
        },
        mounted(){   
            Fire.$on('CreateUser',() => {
               this.createUser();
            });
            Fire.$on('UpdateUser',() => {
               this.updateUser(this.form.id);
            });
        },
        computed:{
            ...mapGetters(["usersRoutes"]),
        },
        methods:{  
            createUser(){
                this.submitted = true;
                this.$Progress.start();
                this.form.post(this.usersRoutes.store).then((response)=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'User created successfully'
                    });
                    this.$Progress.finish();
                }).catch((error)=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                })
            },
            updateUser(id){
                this.submitted = true;
                this.$Progress.start();
                this.form.patch(this.usersRoutes.update+id).then((response)=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'User updated successfully'
                    });
                    this.$Progress.finish();
                }).catch((error)=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                })
            },
        },
        components:{
            "form-extend": FormEx
        }
    }
</script>