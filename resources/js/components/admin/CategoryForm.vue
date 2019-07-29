<template>
    <form-extend data-name="Category" :mode="mode">
        <template slot="inputFields">
            <v-layout row wrap v-if="fetching">
                <v-flex xs6 offset-xs3>
                    <vue-simple-spinner message="Loading" size="large" />
                </v-flex>
            </v-layout>
            <div v-if="!fetching">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label text-sm-right">Name</label>
                    <div class="col-sm-9">
                        <input v-model="form.name" id="name" type="text" name="name" placeholder="Category Name" autocomplete="name"
                            class="form-control" :class="{ 'is-valid': !form.errors.has('name') && isSubmitted,'is-invalid': form.errors.has('name') }">
                    </div>
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group row">
                    <label for="parent" class="col-sm-3 col-form-label text-sm-right">Parent</label>
                    <div class="col-sm-9">
                        <select v-model="form.parent_id" id="parent" name="parent_id" class="form-control" :class="{ 'is-valid': !form.errors.has('parent') && isSubmitted,'is-invalid': form.errors.has('parent') }">
                            <option disabled>Select Parent Category</option>
                            <option value=0>None</option>
                            <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                        </select>
                        <has-error :form="form" field="parent"></has-error>
                    </div>
                </div>
            </div>
        </template>
    </form-extend> 
</template>

<script>
    import { mapGetters } from "vuex"
    import FormEx from "./extensions/Form.vue"

    export default {
        name:"CategoryForm",
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
        data(){
            return {
                categories:[],
                fetch:false,
            }
        },
        computed:{
            ...mapGetters(["categoriesRoutes"]),
            fetching(){return this.fetch}
        },
        components:{
            "form-extend": FormEx
        },
        mounted(){
            this.getCategories(this.categoriesRoutes.index);
            Fire.$on('CreateCategory',() => {
               this.createCategory();
            });
            Fire.$on('UpdateCategory',() => {
               this.updateCategory(this.form.id);
            })
        },
        methods:{ 
            getCategories(url){
                this.fetch = true;
                axios.get(url).then((response)=>{
                    this.fetch = false;
                    this.categories = response.data.data;
                }).catch(error=>{
                    new toast({
                        type: 'error',
                        title: 'Unable to fetch data'
                    });
                    this.fetch = false;
                })
            },
            createCategory(){
                this.submitted = true;
                this.$Progress.start();
                this.form.post(this.categoriesRoutes.store).then(()=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'Category created successfully'
                    });
                    this.$Progress.finish();
                }).catch(()=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                    new toast({
                        type: 'error',
                        title: 'Error creating category'
                    });
                })
            },
            updateCategory(id){
                this.submitted = true;
                this.$Progress.start();
                this.form.patch(this.categoriesRoutes.update+id).then(()=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'Category updated successfully'
                    });
                    this.$Progress.finish();
                }).catch(()=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                    new toast({
                        type: 'error',
                        title: 'Error updating category'
                    });
                })
            },
        }
    }
</script>
