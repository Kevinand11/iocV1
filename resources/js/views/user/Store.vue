<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<form @submit.prevent="updateProfile">
					<div class="text-center">
						<img :src="decideImage" alt='' id="profile" width="80px" height="80px"/><br>
						<span class="lead">{{ $t('storeFormPreview') }}</span>
					</div>
					<div class="form-group row">
						<label for="image" class="col-sm-2 col-form-label">{{ $t('storeFormPhotoLabel') }}</label>
						<div class="col-sm-12">
							<input type="file" @change="setPicture" name="image" :class="{ 'is-valid': !form.errors.has('image') && isSubmitted,'is-invalid': form.errors.has('image') }"
								   class="form-control-file" id="image">
						</div>
					</div>
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">{{ $t('storeFormNameLabel') }}</label>
						<div class="col-sm-12">
							<input type="text" v-model="form.name" class="form-control" id="name" :placeholder="$t('storeFormNamePlaceHolder')"
								   :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="business_name">
							<has-error :form="form" field="name"></has-error>
						</div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">{{ $t('storeFormEmailLabel') }}</label>
						<div class="col-sm-12">
							<input type="email" v-model="form.email" class="form-control" id="email" :placeholder="$t('storeFormEmailPlaceHolder')"
								   :class="{ 'is-invalid': form.errors.has('email') }" autocomplete="business_email">
							<has-error :form="form" field="email"></has-error>
						</div>
					</div>
					<div class="form-group row">
						<label for="phone" class="col-sm-2 col-form-label">{{ $t('storeFormPhoneLabel') }}</label>
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-4">
									<select name="country_code" id="country" class="form-control" v-model="form.phone.phone_country"
											:class="{ 'is-invalid': form.errors.has('phone.phone_country') }" autocomplete="business_phone_country">
										<option v-for="(country,code) in getCountries" :value="code" :key="code">{{ country }}</option>
									</select>
									<has-error :form="form" field="phone.phone_country"></has-error>
								</div>
								<div class="col-sm-8">
									<input type="tel" v-model="form.phone.phone" class="form-control" id="phone" :placeholder="$t('storeFormPhonePlaceHolder')"
										   :class="{ 'is-invalid': form.errors.has('phone.phone') }" autocomplete="business_phone">
									<has-error :form="form" field="phone.phone"></has-error>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="link" class="col-sm-2 col-form-label">{{ $t('storeFormLinkLabel') }}</label>
						<div class="col-sm-12">
							<input type="url" v-model="form.link" class="form-control" id="link" :placeholder="$t('storeFormLinkPlaceHolder')"
								   :class="{ 'is-invalid': form.errors.has('link') }" autocomplete="business_link">
							<has-error :form="form" field="phone"></has-error>
						</div>
					</div>
					<div class="form-group row"><label for="description" class="col-sm-2 col-form-label">{{ $t('storeFormDescriptionLabel') }}</label>
						<div class="col-sm-12">
							<textarea name="description" id="description" v-model="form.description" class="form-control" :placeholder="$t('storeFormDescriptionPlaceHolder')"
								:class="{ 'is-invalid': form.errors.has('description') }" autocomplete="business_description"></textarea>
							<has-error :form="form" field="description"></has-error>
						</div>
					</div>
					<div class="form-group">
						<div class="offset-sm-4 col-sm-4">
							<button type="submit" class="btn btn-success" @click.prevent="updateStore">
								<span v-if="!isDisabled">{{ $t('updateButton') }}</span>
								<i class="fas fa-spinner fa-spin" v-if="isDisabled"></i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex';

	export default {
		name:"Store",
		data(){
			return {
				form: new Form({
					id:null,name:'',email:'', phone:{phone:'',phone_country:'NG'},
					link:'',description:'',
					picture:{}
				}),
				disabled: false,
				submitted: false,
			}
		},
		mounted(){
			if(this.getAuth.store){
				this.form.fill(this.getAuth.store);
			}
		},
		computed:{
			...mapGetters(['getAuth','authRoutes','getCountries','getStoreLogo']),
			isDisabled(){ return this.disabled },
			isSubmitted(){ return this.submitted },
			decideImage(){return !_.isEmpty(this.form.picture) ? this.form.picture.filename : this.getStoreLogo },
		},
		methods:{
			...mapActions(['setAuth']),
			updateStore(){
				this.disabled = true;
				this.submitted = true;
				this.$Progress.start();
				this.form.put(this.authRoutes.updateStore).then(response=>{
					let user = this.getAuth;
					user.store = response.data.data;
					this.setAuth({user,remember:true});
					this.disabled = false;
					this.submitted = false;
					this.$Progress.finish();
					new toast({
						type:'success',
						title:this.$t('storeFormUpdatedSuccess'),
					});
				}).catch(error=>{
					this.disabled = false;
					this.$Progress.fail();
					new toast({
						type:'error',
						title:this.$t('storeFormUpdatedError'),
					});
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
							title: this.$t('fileUploadOops'),
							text: this.$t('fileUploadLimit'),
						});
						return false;
					}
					reader.onloadend = (file) => {
						this.form.image = reader.result;
						$('#profile').attr('src',reader.result);
					};
					reader.readAsDataURL(file);
				}
			},
		}
	}
</script>
