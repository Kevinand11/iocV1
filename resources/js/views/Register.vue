<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form method="POST" action="/register" @submit.prevent="regUser">
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

    export default {
        name:"Register",
        data(){
            return {
                csrf: document.querySelector("meta[name='csrf-token']").getAttribute("content"),
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation:'',
                    _token:this.csrf,
                }),
                submitted:false,
                disabled:false,
            }
        },
        computed:{
            ...mapGetters(["getIntended"]),
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
                this.form.post("/api/users/register").then(response=>{
                    this.setAuth(response.data.success.user);
                    this.setToken(response.data.success.token);
                    this.$Progress.finish();
                    this.disabled = false;
                    this.$router.push(this.getIntended);
                    this.clearIntended();
                }).catch(error=>{
                    this.$Progress.fail();
                    this.disabled = false;
                })
            },
        }
    }
</script>