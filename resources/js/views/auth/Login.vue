<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h3 class="card-header">{{ $t('loginHeader') }}</h3>
                    <div class="card-body">
                        <form method="POST" @submit.prevent="loginUser">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ $t('userFormEmailLabel') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" :class="{ 'is-valid': !form.errors.has('email') && isSubmitted,'is-invalid': form.errors.has('email') }"
                                    v-model="form.email" autocomplete="email" autofocus :placeholder="$t('userFormLoginEmailPlaceHolder')">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ $t('userFormPasswordLabel') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" :class="{ 'is-valid': !form.errors.has('password') && isSubmitted,'is-invalid': form.errors.has('password') || form.errors.has('email') }"
                                    v-model="form.password" autocomplete="password" autofocus :placeholder="$t('userFormLoginPasswordPlaceHolder')">
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="form.remember">
                                        <label class="form-check-label" for="remember">{{ $t('userFormLoginRememberMeLabel') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" :disabled="isDisabled || isEmpty">
                                        <span v-if="!isDisabled">{{ $t('loginButton') }}</span>
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

<script>
    import { mapActions,mapGetters } from "vuex"

    export default {
        name:"Login",
        data(){
            return {
                csrf: document.querySelector("meta[name='csrf-token']").getAttribute("content"),
                form: new Form({
                    email: '',
                    password: '',
                    remember:true,
                    _token:this.csrf,
                }),
                submitted:false,
                disabled:false,
                visible:false,
            }
        },
        computed:{
            ...mapGetters(["getIntended","getAuth","authRoutes"]),
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
                this.form.post(this.authRoutes.login).then(response=>{
                    this.setToken({token:response.data.data,remember:this.form.remember});
                    axios.get(this.authRoutes.profile).then(response=>{
                        this.setAuth({user:response.data.data,remember:this.form.remember});
                        this.disabled = false;
						this.$router.push(this.getIntended);
						this.clearIntended();
						this.$Progress.finish();
						new toast({
							type: 'success',
							title: this.$t('loginSuccess'),
						});
					}).catch(()=>{
                        this.disabled = false;
						this.$Progress.fail();
						new toast({
							type: 'error',
							title: this.$t('unexpectedError'),
						});
					});
                }).catch(()=>{
					this.disabled = false;
					this.$Progress.fail();
					new toast({
						type: 'error',
						title: this.$t('loginError'),
					});
                });
            },
        }
    }
</script>
