<template>
    <form-extend data-name="User" :mode="mode">
        <div slot="inputFields">
            <div class="form-group">
                <input v-model="form.name" type="text" name="name" placeholder="Name"
                    class="form-control" :class="{ 'is-valid': !form.errors.has('name') && isSubmitted,'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
            </div>
            <div class="form-group">
                <input v-model="form.email" name="email" type="email" placeholder="Email"
                class="form-control" :class="{ 'is-valid': !form.errors.has('email') && isSubmitted,'is-invalid': form.errors.has('email') }">
                <has-error :form="form" field="email"></has-error>
            </div>
            <div class="form-group">
                <input v-model="form.password" type="password" name="password" placeholder="Password"
                    class="form-control" :class="{ 'is-valid': !form.errors.has('password') && isSubmitted,'is-invalid': form.errors.has('password') }">
                <has-error :form="form" field="password"></has-error>
            </div>
            <div class="form-group">
                <input v-model="form.password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password"
                    class="form-control" :class="{ 'is-valid': !form.errors.has('password_confirmation') && isSubmitted,'is-invalid': form.errors.has('password_confirmation') }">
                <has-error :form="form" field="password_confirmation"></has-error>
            </div>
        </div>
    </form-extend>
</template>

<script>
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
        methods:{  
            createUser(){
                this.submitted = true;
                this.$Progress.start();
                this.form.post('/api/users/').then((response)=>{
                    Fire.$emit('Reload');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'User created successfully'
                    });
                    this.$Progress.finish();
                }).catch((error)=>{
                    Fire.$emit('AfterCreate');
                    this.$Progress.fail();
                })
            },
            updateUser(id){
                this.submitted = true;
                this.$Progress.start();
                this.form.patch('/api/users/'+id).then((response)=>{
                    Fire.$emit('Reload');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'User updated successfully'
                    });
                    this.$Progress.finish();
                }).catch((error)=>{
                    Fire.$emit('AfterCreate');
                    this.$Progress.fail();
                })
            },
        },
        components:{
            "form-extend": FormEx
        }
    }
</script>