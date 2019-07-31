<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h3 class="card-header">Register</h3>
                    <div class="card-body">
                        <form method="POST" @submit.prevent="regUser">
                            <div class="text-center">
                                <img src="img/profile.png" id="profile" alt='' width="80px" height="80px"/>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-right">Profile Photo</label>
                                <div class="col-md-6">
                                    <input type="file" @change="setPicture" name="image" :class="{ 'is-valid': !form.errors.has('image') && isSubmitted,'is-invalid': form.errors.has('image') }"
                                        class="form-control" id="image">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="name" class="form-control" name="name" :class="{ 'is-valid': !form.errors.has('name') && isSubmitted,'is-invalid': form.errors.has('name') }"
                                        v-model="form.name" autocomplete="name" autofocus>
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" :class="{ 'is-valid': !form.errors.has('email') && isSubmitted,'is-invalid': form.errors.has('email') }"
                                        v-model="form.email" autocomplete="email" autofocus>
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Phone Number</label>
                                <div class="col-md-6">
                                    <phone-input v-model="form.phone" name="phone" default-country-code="NG" autocomplete="phone"
                                        :class="{ 'is-valid': !form.errors.has('phone') && isSubmitted,'is-invalid': form.errors.has('phone') }" />
                                    <has-error :form="form" field="phone"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" :class="{ 'is-valid': !form.errors.has('password') && isSubmitted,'is-invalid': form.errors.has('password') }"
                                        v-model="form.password" autocomplete="new-password" autofocus>
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" :class="{ 'is-valid': !form.errors.has('password') && isSubmitted,'is-invalid': form.errors.has('password') }"
                                        v-model="form.password_confirmation" autocomplete="new-password" autofocus>
                                    <has-error :form="form" field="password_confirmation"></has-error>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" :disabled="isDisabled || isEmpty">
                                        <span v-if="!isDisabled">Register</span>
                                        <i class="fas fa-spinner fa-spin" v-if="isDisabled"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<<script>
    import { mapActions,mapGetters } from "vuex"
    import VuePhoneNumberInput from 'vue-phone-number-input'

    export default {
        name:"Register",
        components: {
            'phone-input': VuePhoneNumberInput
        },
        data(){
            return {
                csrf: document.querySelector("meta[name='csrf-token']").getAttribute("content"),
                form: new Form({
                    name: '',
                    email: '',
                    phone: '',
                    password: '',
                    password_confirmation:'',
                    _token:this.csrf,
                    image: ''
                }),
                submitted:false,
                disabled:false,
            }
        },
        computed:{
            ...mapGetters(["getIntended","authRoutes"]),
            isDisabled(){return this.disabled},
            isSubmitted(){return this.submitted},
            isEmpty(){ return !(this.form.name && this.form.email && this.form.password && this.form.password_confirmation) }
        },
        methods:{
            ...mapActions(["setAuth","setToken","clearIntended"]),
            regUser(){
                this.disabled = true;
                this.submitted = true;
                this.$Progress.start();
                this.form.post(this.authRoutes.register).then(response=>{
                    this.setToken({token:response.data.data,remember:true});
                    axios.get(this.authRoutes.profile).then(response=>{
                        this.setAuth({user:response.data.data,remember:true});
                        this.$Progress.finish();
                        this.disabled = false;
                        this.$router.push(this.getIntended);
                        this.clearIntended();
                    }).catch(()=>{
                        this.$Progress.fail();
                        this.disabled = false;
                    });
                }).catch(()=>{
                    this.$Progress.fail();
                    this.disabled = false;
                });
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
                    }
                    reader.readAsDataURL(file);
                }
            }
        }
    }
</script>
