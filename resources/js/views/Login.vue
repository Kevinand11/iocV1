<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form method="POST" action="/login" @submit.prevent="loginUser">
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
                                    <input id="password" type="password" class="form-control" name="password" :class="{ 'is-valid': !(form.errors.has('password') || form.errors.has('email')) && isSubmitted,'is-invalid': form.errors.has('password') || form.errors.has('email') }"
                                    v-model="form.password" autocomplete="password" autofocus>
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="form.remember">
                                        <label class="form-check-label" for="remember">Remember Me?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" :disabled="isDisabled || isEmpty">
                                        <span v-if="!isDisabled">Login</span>
                                        <i class="fas fa-spinner fa-spin" v-if="isDisabled"></i>
                                    </button>
                                    <!-- @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif -->
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
        name:"Login",
        data(){
            return {
                csrf: document.querySelector("meta[name='csrf-token']").getAttribute("content"),
                form: new Form({
                    email: '',
                    password: '',
                    remember:false,
                    _token:this.csrf,
                }),
                submitted:false,
                disabled:false,
            }
        },
        computed:{
            ...mapGetters(["getIntended","getAuth"]),
            isDisabled(){return this.disabled},
            isSubmitted(){return this.submitted},
            isEmpty(){ return !(this.form.email && this.form.password) }
        },
        methods:{
            ...mapActions(["setAuth","setToken","clearIntended"]),
            loginUser(){
                this.disabled = true;
                this.submitted = true;
                this.$Progress.start();
                this.form.post("/api/users/login").then(response=>{
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