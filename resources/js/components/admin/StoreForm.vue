<template>
    <form-extend data-name="Store" :mode="mode">
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
                    <input v-model="form.name" id="name" type="text" name="name" placeholder="Business Name" autocomplete="business_name"
                           class="form-control" :class="{ 'is-valid': !form.errors.has('name') && isSubmitted,'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label text-sm-right">Email</label>
                <div class="col-sm-9">
                    <input v-model="form.email" id="email" name="email" type="email" placeholder="Business Email" autocomplete="business_email"
                           class="form-control" :class="{ 'is-valid': !form.errors.has('email') && isSubmitted,'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label text-sm-right">Phone</label>
                <div class="col-sm-9">
                    <phone-input v-model="form.phone" id="phone" name="phone" default-country-code="NG" autocomplete="business_phone"
                                 :class="{ 'is-valid': !form.errors.has('phone') && isSubmitted,'is-invalid': form.errors.has('phone') }" />
                    <has-error :form="form" field="phone"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="link" class="col-sm-3 col-form-label text-sm-right">Link</label>
                <div class="col-sm-9">
                    <input v-model="form.link" id="link" type="url" name="link" placeholder="Business Website" autocomplete="business_link"
                           class="form-control" :class="{ 'is-valid': !form.errors.has('link') && isSubmitted,'is-invalid': form.errors.has('link') }">
                    <has-error :form="form" field="link"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="desc" class="col-sm-3 col-form-label text-sm-right">Description</label>
                <div class="col-sm-9">
                    <textarea v-model="form.description" id="desc" type="text" name="description" placeholder="More About Your Business" autocomplete="business_description"
                        class="form-control" :class="{ 'is-valid': !form.errors.has('description') && isSubmitted,'is-invalid': form.errors.has('description') }"></textarea>
                    <has-error :form="form" field="description"></has-error>
                </div>
            </div>
        </template>
    </form-extend>
</template>

<script>
    import { mapGetters } from "vuex"
    import VuePhoneNumberInput from 'vue-phone-number-input'
    import FormEx from "../Form.vue"

    export default {
        name:"StoreForm",
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
            Fire.$on('CreateStore',() => {
                this.createStore();
            });
            Fire.$on('UpdateStore',() => {
                this.updateStore(this.form.id);
            });
        },
        computed:{
            ...mapGetters(["storesRoutes",'getAuth']),
            decideImage(){return !_.isEmpty(this.form.picture) ? '../'+this.form.picture.filename : '../img/logo.png'},
        },
        methods:{
            createStore(){
                this.submitted = true;
                this.$Progress.start();
                this.form.user_id = this.getAuth.id;
                this.form.post(this.storesRoutes.store).then((response)=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'Store created successfully'
                    });
                    this.$Progress.finish();
                }).catch((error)=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                })
            },
            updateStore(id){
                this.submitted = true;
                this.$Progress.start();
                this.form.patch(this.storesRoutes.update+id).then((response)=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'Store updated successfully'
                    });
                    this.$Progress.finish();
                }).catch((error)=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
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
                        })
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
