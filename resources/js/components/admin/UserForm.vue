<template>
    <form-extend data-name="User" :mode="mode">
        <template slot="inputFields">
            <div class="text-center">
                <img :src="decideImage" alt='' id="profile" width="80px" height="80px"/><br>
                <span class="lead">Preview</span>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-3 col-form-label text-sm-right">Photo</label>
                <div class="col-sm-9">
                    <input type="file" @change="setPicture" name="image" :class="{ 'is-valid': !form.errors.has('image') && isSubmitted,'is-invalid': form.errors.has('image') }"
                       class="form-control-file" id="image">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-sm-right">Name</label>
                <div class="col-sm-9">
                    <input id="name" v-model="form.name" type="text" name="name" placeholder="Name" autocomplete="name"
                        class="form-control" :class="{ 'is-valid': !form.errors.has('name') && isSubmitted,'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label text-sm-right">Email</label>
                <div class="col-sm-9">
                    <input id="email" v-model="form.email" name="email" type="email" placeholder="Email" autocomplete="email"
                        class="form-control" :class="{ 'is-valid': !form.errors.has('email') && isSubmitted,'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label text-sm-right">Phone</label>
                <div class="col-sm-9">
                    <phone-input v-model="form.phone" id="phone" name="phone" default-country-code="NG" autocomplete="phone"
                        :class="{ 'is-valid': !form.errors.has('phone') && isSubmitted,'is-invalid': form.errors.has('phone') }" />
                    <has-error :form="form" field="phone"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="role" class="col-sm-3 col-form-label text-sm-right">Role</label>
                <div class="col-sm-9">
                    <select id="role" v-model="form.role" name="role" class="form-control">
                        <option value="user">user</option>
                        <option value="admin">admin</option>
                    </select>
                    <has-error :form="form" field="category_id"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label text-sm-right">Password</label>
                <div class="col-sm-9">
                    <input v-model="form.password" id="password" type="password" name="password" placeholder="Password" autocomplete="password"
                           class="form-control" :class="{ 'is-valid': !form.errors.has('password') && isSubmitted,'is-invalid': form.errors.has('password') }">
                    <has-error :form="form" field="password"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirm" class="col-sm-3 col-form-label text-sm-right">Confirm</label>
                <div class="col-sm-9">
                    <input v-model="form.password_confirmation" id="confirm" type="password" name="password_confirmation" placeholder="Confirm Password" autocomplete="password_confirmation"
                        class="form-control" :class="{ 'is-valid': !form.errors.has('password_confirmation') && isSubmitted,'is-invalid': form.errors.has('password_confirmation') }">
                    <has-error :form="form" field="password_confirmation"></has-error>
                </div>
            </div>
        </template>
    </form-extend>
</template>

<script>
    import { mapGetters } from "vuex"
    import VuePhoneNumberInput from 'vue-phone-number-input'
    import FormEx from "./extensions/Form.vue"

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
            decideImage(){return !_.isEmpty(this.form.picture) ? '../'+this.form.picture.filename : '../img/profile.png'},
        },
        methods:{
            createUser(){
                this.submitted = true;
                this.$Progress.start();
                this.form.post(this.usersRoutes.store).then(()=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'User created successfully'
                    });
                    this.$Progress.finish();
                }).catch(()=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                    new toast({
                        type: 'error',
                        title: 'Error creating user'
                    });
                })
            },
            updateUser(id){
                this.submitted = true;
                this.$Progress.start();
                this.form.patch(this.usersRoutes.update+id).then(()=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'User updated successfully'
                    });
                    this.$Progress.finish();
                }).catch(()=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                    new toast({
                        type: 'error',
                        title: 'Error updating user'
                    });
                })
            },
            setPicture(e){
                let file = e.target.files[0];
                if(file){
                    let reader = new FileReader();
                    let limit = 1024 * 1024 * 2;
                    if(file['size'] > limit){
                        swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'File shouldnt be more than 2MB',
                        });
                        return false;
                    }
                    reader.onloadend = (file) => {
                        this.form.image = reader.result;
                        $('#profile').attr('src',reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        },
        components:{
            "form-extend": FormEx,
            "phone-input": VuePhoneNumberInput,
        }
    }
</script>
