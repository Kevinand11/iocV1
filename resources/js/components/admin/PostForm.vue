<template>
    <form-extend data-name="Post" :mode="mode">
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
                        <input v-model="form.name" type="text" id="name" name="name" placeholder="Name" autocomplete="name"
                            class="form-control" :class="{ 'is-valid': !form.errors.has('name') && isSubmitted,'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price" class="col-sm-3 col-form-label text-sm-right">Price</label>
                    <div class="col-sm-9">
                        <input id="price" v-model="form.price" name="price" type="number" placeholder="Price" autocomplete="price"
                             class="form-control" :class="{ 'is-valid': !form.errors.has('price') && isSubmitted,'is-invalid': form.errors.has('price') }">
                        <has-error :form="form" field="price"></has-error>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="desc" class="col-sm-3 col-form-label text-sm-right">Description</label>
                    <div class="col-sm-9">
                        <textarea id="desc" v-model="form.description" name="description" placeholder="Description" autocomplete="description"
                            class="form-control" :class="{ 'is-valid': !form.errors.has('description') && isSubmitted,'is-invalid': form.errors.has('description') }"></textarea>
                        <has-error :form="form" field="description"></has-error>
                    </div>
                    <has-error :form="form" field="description"></has-error>
                </div>
                <div class="form-group row">
                    <label for="category" class="col-sm-3 col-form-label text-sm-right">Category</label>
                    <div class="col-sm-9">
                        <select v-model="form.category_id" id='category' name="category_id" class="form-control" :class="{ 'is-valid': !form.errors.has('category_id') && isSubmitted,'is-invalid': form.errors.has('category_id') }">
                            <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                        </select>
                        <has-error :form="form" field="category_id"></has-error>
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
        name:"PostForm",
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
            ...mapGetters(["postsRoutes","categoriesRoutes",'getAuth']),
            fetching(){return this.fetch}
        },
        components:{
            "form-extend": FormEx
        },
        mounted(){
            this.getCategories(this.categoriesRoutes.index);
            Fire.$on('CreatePost',() => {
               this.createPost();
            });
            Fire.$on('UpdatePost',() => {
               this.updatePost(this.form.id);
            });
        },
        methods:{ 
            getCategories(url){
                this.fetch = true;
                axios.get(url).then((response)=>{
                    this.fetch = false;
                    this.categories = response.data.data;
                }).catch(()=>{
                    new toast({
                        type: 'error',
                        title: 'Unable to fetch data'
                    });
                    this.fetch = false;
                })
            },
            createPost(){
                this.submitted = true;
                this.$Progress.start();
                this.form.post(this.postsRoutes.store).then(()=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'Post created successfully'
                    });
                    this.$Progress.finish();
                }).catch(()=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                    new toast({
                        type: 'error',
                        title: 'Error creating post'
                    });
                })
            },
            updatePost(id){
                this.submitted = true;
                this.$Progress.start();
                this.form.patch(this.postsRoutes.update+id).then(()=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'Post updated successfully'
                    });
                    this.$Progress.finish();
                }).catch(()=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                    new toast({
                        type: 'error',
                        title: 'Error updating post'
                    });
                })
            },
        }
    }
</script>
