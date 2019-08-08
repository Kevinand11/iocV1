<template>
    <v-container grid-list-xs>
        <v-btn small color="primary" @click="goBack">{{ $t('goBackButton') }}</v-btn>
        <v-layout row wrap v-if="fetching">
            <v-flex xs6 offset-xs3>
                <vue-simple-spinner :message="$t('loadingSpinner')" size="large" />
            </v-flex>
        </v-layout>
        <v-container v-if="!fetching">
            <v-layout row wrap v-if='anyPictures'>
                <v-carousel>
                    <v-carousel-item v-for="img in post.pictures" :src="img.filename | appendURL" :key="img.id"></v-carousel-item>
                </v-carousel>
            </v-layout>
            <v-layout row wrap mt-2>
                <span class="lead">{{ post.name }}</span>
                <v-spacer></v-spacer>
                <span class="float-right">{{ $t('postCategory') }}:{{post.category.name}}</span>
            </v-layout>
            <v-divider ma-0></v-divider>

            <p>{{post.description}}</p><hr>
            <p>{{ $t('postOnlyFor') }}{{ post.price | addNairaSign}}</p><hr>
            <p>{{ $t('postPostedFrom') }} {{ post.store.name }} ({{ post.store.user.name }}) on {{ post.created_at | myDate }}</p>
            <p>{{ $t('postContactThemAt') }} <a :href="'mailto:'+post.store.phone.phone">{{ post.store.phone.phone }}</a> {{ $t('postOr') }} <a :href="'mailto:'+post.store.email">{{ post.store.email }}</a></p>
            <p>{{ $t('postLastUpdatedOn') }} {{ post.updated_at|myDate }}</p>
            <v-layout row wrap v-if="isMyPost">
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
                    store:{user:{},phone:{}},category:{},category_id:null,pictures:[],created_at:"",updated_at:""
                },
                form: new Form({
                    id : null, name : '', description: '',
                    price: '', category_id: null,
                }),
            }
        },
        mounted(){
            this.getPost(this.$route.params.id)
        },
        computed: {
            ...mapGetters(["getAuth","getPreviousNonAuthRoute","postsRoutes"]),
            fetching(){ return this.fetch },
            anyPictures(){ return !_.isEmpty(this.post.pictures) },
            isMyPost(){ return this.getAuth.id === this.post.store.user.id }
        },
        methods: {
        	getPost(id){
                this.fetch = true
                axios.get(this.postsRoutes.show+id).then(response=>{
                    this.fetch = false;
                    this.post = response.data.data
                }).catch(error=>{
                    new toast({
                        type: 'error',
                        title: this.$t('postFetchError'),
                    });
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
