<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h3 class="card-header">Login</h3>
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
                                    <input id="password" type="password" class="form-control" name="password" :class="{ 'is-valid': !form.errors.has('password') && isSubmitted,'is-invalid': form.errors.has('password') || form.errors.has('email') }"
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
                                    <!-- <a class="btn btn-link" href='password/request'>
                                        Forgot Your Password?
                                    </a> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <v-container grid-list-xs>
        <v-card>
            <v-card-title primary-title>
                <h3>Login</h3>
            </v-card-title>
            <v-card-text>
                <v-form method="POST" action="/login" @submit.prevent="loginUser">
                    <v-layout row wrap>
                        <v-flex xs8 offset-xs2>
                            <v-text-field name="email" label="Email Address"
                                autocomplete="email" min="4" clearable 
                                :success = "isSubmitted && !hasErrors('email')"
                                :error = "isSubmitted && hasErrors('email')"
                                :error-messages="form.errors.get('email')"
                                type ="email" v-model="form.email"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs8 offset-xs2>
                            <v-text-field name="password" label="Password"
                                hint="Password should be up at least characters"
                                autocomplete="password" min="6" clearable 
                                :success = "isSubmitted && !hasErrors('password')"
                                :error = "isSubmitted && hasErrors('password')"
                                :error-messages="form.errors.get('password')"
                                :append-icon ="visible ? 'visibility_off' : 'visibility'"
                                @click:append ="() => (visible = !visible)"
                                :type ="visible ? 'text' : 'password'"
                                v-model="form.password"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs6 offset-xs2>
                            <v-checkbox label="Remember Me?" v-model="form.remember" value="value"></v-checkbox>
                        </v-flex>
                    </v-layout>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-layout row wrap>
                    <v-flex xs6 offset-xs6>
                        <v-btn color="primary" @click="loginUser" :disabled="isDisabled || isEmpty">
                            <span v-if="!isDisabled">Login</span>
                            <i class="fas fa-spinner fa-spin" v-if="isDisabled"></i>
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-card-actions>
        </v-card>
    </v-container> -->
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
                    remember:false,
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
                    this.setToken(response.data.data);
                    window.axios.defaults.headers.common['Authorization'] = "Bearer " + response.data.data;
                    axios.get(this.authRoutes.profile).then(response=>{
                        this.setAuth(response.data.data);
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
            hasErrors(field){
                return this.form.errors.has(field)
            }
        }
    }
</script>
