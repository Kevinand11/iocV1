<template>
    <form-extend data-name="User" :mode="mode">
        <template slot="inputFields">
            <div class="text-center">
                <img :src="decideImage | appendURL" alt='' id="profile" width="80px" height="80px"/><br>
                <span class="lead">{{ $t('userFormPreview') }}</span>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-3 col-form-label text-sm-right">{{ $t('userFormPhotoLabel') }}</label>
                <div class="col-sm-9">
                    <input type="file" @change="setPicture" name="image" :class="{ 'is-valid': !form.errors.has('image') && isSubmitted,'is-invalid': form.errors.has('image') }"
                       class="form-control-file" id="image">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-sm-right">{{ $t('userFormNameLabel') }}</label>
                <div class="col-sm-9">
                    <input id="name" v-model="form.name" type="text" name="name" :placeholder="$t('userFormNamePlaceHolder')" autocomplete="name"
                        class="form-control" :class="{ 'is-valid': !form.errors.has('name') && isSubmitted,'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label text-sm-right">{{ $t('userFormEmailLabel') }}</label>
                <div class="col-sm-9">
                    <input id="email" v-model="form.email" name="email" type="email" :placeholder="$t('userFormEmailPlaceHolder')" autocomplete="email"
                        class="form-control" :class="{ 'is-valid': !form.errors.has('email') && isSubmitted,'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                </div>
            </div>
			<div class="form-group row">
				<label for="phone" class="col-sm-3 col-form-label text-sm-right">{{ $t('userFormPhoneLabel') }}</label>
				<div class="col-sm-9">
					<div class="row">
						<div class="col-sm-4">
							<select name="country_code" id="country" class="form-control" v-model="form.phone.phone_country"
									:class="{ 'is-invalid': form.errors.has('phone.country') }" autocomplete="phone_country">
								<option v-for="(country,code) in getCountries" :value="code" :key="code">{{ country }}</option>
							</select>
							<has-error :form="form" field="phone.phone_country"></has-error>
						</div>
						<div class="col-sm-8">
							<input type="tel" v-model="form.phone.phone" class="form-control" id="phone" :placeholder="$t('userFormPhonePlaceHolder')"
								   :class="{ 'is-invalid': form.errors.has('phone.phone') }" autocomplete="phone">
							<has-error :form="form" field="phone.phone"></has-error>
						</div>
					</div>
				</div>
			</div>
            <div class="form-group row">
                <label for="role" class="col-sm-3 col-form-label text-sm-right">{{ $t('userFormRoleLabel') }}</label>
                <div class="col-sm-9">
					<select id="role" v-model="form.role" name="role" class="form-control">
						<option v-for='role in getRoles' :key="role.value" :value="role.value">{{ $t(`userFormRole${role.name}`) }}</option>
					</select>
                    <has-error :form="form" field="category_id"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label text-sm-right">{{ $t('userFormPasswordLabel') }}</label>
                <div class="col-sm-9">
                    <input v-model="form.password" id="password" type="password" name="password" :placeholder="$t('userFormPasswordPlaceHolder')" autocomplete="password"
                           class="form-control" :class="{ 'is-valid': !form.errors.has('password') && isSubmitted,'is-invalid': form.errors.has('password') }">
                    <has-error :form="form" field="password"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirm" class="col-sm-3 col-form-label text-sm-right">{{ $t('userFormConfirmPasswordLabel') }}</label>
                <div class="col-sm-9">
                    <input v-model="form.password_confirmation" id="confirm" type="password" name="password_confirmation" :placeholder="$t('userFormConfirmPasswordPlaceHolder')"
						   autocomplete="password_confirmation" class="form-control" :class="{ 'is-valid': !form.errors.has('password_confirmation') && isSubmitted,'is-invalid': form.errors.has('password_confirmation') }">
                    <has-error :form="form" field="password_confirmation"></has-error>
                </div>
            </div>
        </template>
    </form-extend>
</template>

<script>
    import { mapGetters } from "vuex"
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
            ...mapGetters(["usersRoutes",'getCountries','getRoles','getProfile']),
            decideImage(){return !_.isEmpty(this.form.picture) ? this.form.picture.filename : this.getProfile },
        },
        methods:{
            createUser(){
                this.submitted = true;
                this.$Progress.start();
                this.form.post(this.usersRoutes.store).then(()=>{
                    Fire.$emit('ReloadUsers');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: this.$t('userFormCreateSuccess')
                    });
                    this.$Progress.finish();
                }).catch(()=>{
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                    new toast({
                        type: 'error',
                        title: this.$t('userFormCreateError')
                    });
                })
            },
            updateUser(id){
                this.submitted = true;
                this.$Progress.start();
                this.form.patch(this.usersRoutes.update+id).then(()=>{
                    Fire.$emit('ReloadUsers');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: this.$t('userFormUpdateSuccess')
                    });
                    this.$Progress.finish();
                }).catch(()=>{
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                    new toast({
                        type: 'error',
                        title: this.$t('userFormUpdateError')
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
                            title: this.$t('fileUploadOops'),
                            text: this.$t('fileUploadLimit')
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
        }
    }
</script>
