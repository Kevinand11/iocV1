<template>
    <form-extend data-name="Category" :mode="mode">
        <div slot="inputFields">
            <vue-simple-spinner message="Loading" size="medium" v-if="fetching" class="text-center" />
            <div v-if="!fetching">
                <div class="form-group">
                    <input v-model="form.name" type="text" name="name" placeholder="Name" autocomplete="name"
                        class="form-control" :class="{ 'is-valid': !form.errors.has('name') && isSubmitted,'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                    <select v-model="form.parent" name="parent" class="form-control" :class="{ 'is-valid': !form.errors.has('parent') && isSubmitted,'is-invalid': form.errors.has('parent') }">
                        <option disabled>Select Parent Category</option>
                        <option value="None">None</option>
                        <option v-for="category in categories" :value="category.name">{{category.name}}</option>
                    </select>
                    <has-error :form="form" field="parent"></has-error>
                </div>
            </div>
        </div>
    </form-extend> 
</template>

<script>
    import { mapGetters } from "vuex"
    import FormEx from "../Form.vue"

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
                    this.categories = response.data;
                }).catch(error=>{
                    this.fetch = false;
                })
            },
            createCategory(){
                this.submitted = true;
                this.$Progress.start();
                this.form.post(this.categoriesRoutes.store).then((response)=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'Category created successfully'
                    });
                    this.$Progress.finish();
                }).catch((error)=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                })
            },
            updateCategory(id){
                this.submitted = true;
                this.$Progress.start();
                this.form.patch(this.categoriesRoutes.update+id).then((response)=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'Category updated successfully'
                    });
                    this.$Progress.finish();
                }).catch((error)=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                })
            },
        }
    }
</script>