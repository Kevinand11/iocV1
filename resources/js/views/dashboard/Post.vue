<template>
    <v-container grid-list-xs>
        <v-btn small color="primary" @click="goBack">Go Back</v-btn>
        <v-layout row wrap v-if="fetching">
            <v-flex xs6 offset-xs3>
                <vue-simple-spinner message="Loading" size="large" />
            </v-flex>
        </v-layout>
        <v-container v-if="!fetching">
            <v-layout row wrap>
                <v-carousel>
                    <v-carousel-item :src="img" :key="i"
                        v-for="(img,i) in ['../../../img/logo.png','../../../img/logo.png','../../../img/logo.png','../../../img/logo.png']"
                    ></v-carousel-item>
                </v-carousel>
            </v-layout>
            <v-layout row wrap mt-2>
                <span class="lead">{{ post.name }}</span>
                <v-spacer></v-spacer>
                <span class="float-right">Category:{{post.category.name}}</span>
            </v-layout>
            <v-divider ma-0></v-divider>
            
            
            <p>{{post.description}}</p><hr>
            <p>Only for #{{ post.price }}</p><hr>
            <p>Posted by {{post.user.name}} (<a :href="'mailto:'+post.user.phone">{{post.user.phone}}</a>) (<a :href="'mailto:'+post.user.email">{{post.user.email}}</a>) on {{post.created_at | myDate}}</p>
            <p>Last updated on {{post.updated_at|myDate}}</p>
            <v-layout row wrap>
                <v-btn small icon>
                    <v-icon color="warning" @click="editModal">fas fa-pen</v-icon>
                </v-btn>
                <v-spacer></v-spacer>
                <V-btn small icon>
                    <v-icon color="error">fas fa-trash</v-icon>
                </V-btn>
            </v-layout>
            <post-form mode="edit" :form="this.form" :isSubmitted="false" />
        </v-container>
    </v-container>
</template>

<script>
    import { mapGetters } from "vuex"
    import PostForm from "../../components/admin/PostForm"

    export default {
        name:"Post",
        data(){
            return {
                fetch:false,
                post:{
                    id:"",name:"",description:"",price:"",
                    user:{},category:{},created_at:"",updated_at:""
                },
                form: new Form({
                    id : null, name : '', description: '',
                    price: '', user_id: null, category_id: null,
                }),
            }
        },
        mounted(){
            this.getPost(this.$route.params.id)
        },
        computed: {
            ...mapGetters(["getAuth","getPreviousNonAuthRoute","postsRoutes"]),
            fetching(){ return this.fetch },
            isMyPost(){ return this.getAuth.id == this.post.id }
        },
        methods: {
            getPost(id){
                this.fetch = true
                axios.get(this.postsRoutes.show+id).then(response=>{
                    this.fetch = false
                    this.post = response.data.data
                }).catch(error=>{
                })
            },
            goBack(){
                this.$router.push(this.getPreviousNonAuthRoute)
            },
            editModal(){
                this.form.errors.errors = {};
                this.form.fill(this.post);
                $('#form').modal('show');
            },
        },
        components: {
            "post-form":PostForm
        }
    }
</script>