<template>
    <form-extend data-name="Post" :mode="mode">
        <div slot="inputFields">
            <vue-simple-spinner message="Loading" size="medium" v-if="fetching" class="text-center" />
            <div v-if="!fetching">
                <div class="form-group">
                    <input v-model="form.name" type="text" name="name" placeholder="Name" autocomplete="name"
                        class="form-control" :class="{ 'is-valid': !form.errors.has('name') && isSubmitted,'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">#</span>
                        </div>
                        <input v-model="form.price" name="price" type="number" placeholder="Price" autocomplete="price"
                            class="form-control" :class="{ 'is-valid': !form.errors.has('price') && isSubmitted,'is-invalid': form.errors.has('price') }">
                        <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>
                    <has-error :form="form" field="price"></has-error>
                </div>
                <div class="form-group">
                    <textarea v-model="form.description" name="description" placeholder="Description" autocomplete="description"
                        class="form-control" :class="{ 'is-valid': !form.errors.has('description') && isSubmitted,'is-invalid': form.errors.has('description') }"></textarea>
                    <has-error :form="form" field="description"></has-error>
                </div>
                <div class="form-group">
                    <select v-model="form.category_id" name="category_id" class="form-control" :class="{ 'is-valid': !form.errors.has('category_id') && isSubmitted,'is-invalid': form.errors.has('category_id') }">
                        <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                    </select>
                    <has-error :form="form" field="category_id"></has-error>
                </div>
            </div>
        </div>
    </form-extend>
</template>

<script>
    import FormEx from "../Form.vue"

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
            fetching(){return this.fetch}
        },
        components:{
            "form-extend": FormEx
        },
        mounted(){
            this.getCategories("/api/categories/");
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
                    this.categories = response.data;
                }).catch(error=>{
                    this.fetch = false;
                })
            },
            createPost(){
                this.submitted = true;
                this.$Progress.start();
                this.form.post('/api/posts').then((response)=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'Post created successfully'
                    });
                    this.$Progress.finish();
                    
                }).catch((error)=>{
                    Fire.$emit('AfterCreate');
                    Fire.$emit('Enable');
                    this.$Progress.fail();
                })
            },
            updatePost(id){
                this.submitted = true;
                this.$Progress.start();
                this.form.patch('/api/posts/'+id).then((response)=>{
                    Fire.$emit('Reload');
                    Fire.$emit('Enable');
                    $('#form').modal('hide');
                    new toast({
                        type: 'success',
                        title: 'Post updated successfully'
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