<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
				<form @submit.prevent="updateProfile">
					<div class="text-center">
						<img :src="decideImage" alt='' id="profile" width="80px" height="80px"/><br>
						<span class="lead">Preview</span>
					</div>
					<div class="form-group row">
						<label for="image" class="col-sm-2 col-form-label">Photo</label>
						<div class="col-sm-12">
							<input type="file" @change="setPicture" name="image" :class="{ 'is-valid': !form.errors.has('image') && isSubmitted,'is-invalid': form.errors.has('image') }"
								   class="form-control-file" id="image">
						</div>
					</div>
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Name</label>
						<div class="col-sm-12">
							<input type="text" v-model="form.name" class="form-control" id="name" placeholder="Name"
								   :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="name">
							<has-error :form="form" field="name"></has-error>
						</div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-12">
							<input type="email" v-model="form.email" class="form-control" id="email" placeholder="Email"
								   :class="{ 'is-invalid': form.errors.has('email') }" autocomplete="email">
							<has-error :form="form" field="email"></has-error>
						</div>
					</div>
					<div class="form-group row">
						<label for="phone" class="col-sm-2 col-form-label">Phone</label>
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-4">
									<select name="country_code" id="country" class="form-control" v-model="form.phone.phone_country"
											:class="{ 'is-invalid': form.errors.has('phone.phone_country') }" autocomplete="phone_country">
										<option v-for="(country,code) in getCountries" :value="code" :key="code">{{ country }}</option>
									</select>
									<has-error :form="form" field="phone.phone_country"></has-error>
								</div>
								<div class="col-sm-8">
									<input type="tel" v-model="form.phone.phone" class="form-control" id="phone" placeholder="Phone Number"
										   :class="{ 'is-invalid': form.errors.has('phone.phone') }" autocomplete="phone">
									<has-error :form="form" field="phone.phone"></has-error>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="password" class="col-sm-12 col-form-label">Password (leave empty if not changing)</label>
						<div class="col-sm-12">
							<input type="password" v-model="form.password" class="form-control" id="password" placeholder="Password"
								   :class="{ 'is-invalid': form.errors.has('password') }" autocomplete="password">
							<has-error :form="form" field="password"></has-error>
						</div>
					</div>
					<div class="form-group row">
						<label for="c_password" class="col-sm-12 col-form-label">Confirm Password (if changing)</label>
						<div class="col-sm-12">
							<input type="password" v-model="form.password_confirmation" class="form-control" id="c_password" placeholder="Password confirmation"
								   :class="{ 'is-invalid': form.errors.has('password_confirmation') }" autocomplete="password_confirmation">
							<has-error :form="form" field="password_confirmation"></has-error>
						</div>
					</div>
					<div class="form-group">
						<div class="offset-sm-4 col-sm-4">
							<button type="submit" class="btn btn-success" @click.prevent="updateProfile">
								<span v-if="!isDisabled">Update</span>
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
        name:"Profile",
		data(){
        	return {
        		form: new Form({
					id:null,name:'',email:'', phone:{phone:'',phone_country:'NG'},
					password:'',password_confirmation:'',
					picture:{}
				}),
				disabled: false,
				submitted: false,
			}
		},
		mounted(){
        	this.form.fill(this.getAuth);
		},
        computed:{
            ...mapGetters(['getAuth','authRoutes','getCountries']),
			isDisabled(){ return this.disabled },
			isSubmitted(){ return this.submitted },
			decideImage(){return !_.isEmpty(this.form.picture) ? this.form.picture.filename : 'img/profile.png'},
        },
		methods:{
        	...mapActions(['setAuth']),
        	updateProfile(){
        		this.disabled = true;
        		this.submitted = true;
				this.$Progress.start();
        		this.form.put(this.authRoutes.update).then(response=>{
        			this.setAuth({user:response.data.data,remember:true});
        			this.disabled = false;
        			this.submitted = false;
					this.$Progress.finish();
        			new toast({
						type:'success',
						title:'Profile updated successfully'
					});
				}).catch(error=>{
					this.disabled = false;
					this.$Progress.fail();
					new toast({
						type:'error',
						title:'Failed to update profile'
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
							title: 'Oops...',
							text: 'File should not be more than 2MB',
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
