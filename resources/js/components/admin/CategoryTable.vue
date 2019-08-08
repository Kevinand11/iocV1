<template>
    <table-extend>
        <template slot="headers">
            <tr>
                <th>{{ $t('categoryTableId') }}</th>
                <th>{{ $t('categoryTableName') }}</th>
                <th>{{ $t('categoryTableParent') }}</th>
                <th>{{ $t('categoryTableCreated') }}</th>
                <th>{{ $t('categoryTableUpdated') }}</th>
                <th>{{ $t('categoryTableModifiers') }}</th>
            </tr>
        </template>
        <template slot="rows">
            <tbody>
                <v-layout row wrap v-if="fetching">
                    <v-flex xs6 offset-xs3>
                        <vue-simple-spinner :message="$t('loadingSpinner')" size="large" />
                    </v-flex>
                </v-layout>
                <tr v-for="category in categories.data" :key="category.id" @click="emitCurr(category)" v-if="!fetching">
                    <td>{{category.id}}</td>
                    <td>{{category.name}}</td>
                    <td>{{category.parent ? category.parent.name : ''}}</td>
                    <td>{{category.created_at | myDate}}</td>
                    <td>{{category.updated_at | myDate}}</td>
                    <td>
                        <a @click.prevent="viewModal(category.id)"><i class="fas fa-eye text-blue"></i></a>
                        &nbsp;|&nbsp;
                        <a @click.prevent="emitUpdate(category)"><i class="fas fa-pen text-orange"></i></a>
                        &nbsp;|&nbsp;
                        <a @click.prevent="emitDelete(category.id)"><i class="fas fa-trash text-red"></i></a>
                    </td>
                </tr>
            </tbody>
        </template>
        <template slot="pagination">
            <pagination :data="categories" align="center" :limit="limit" @pagination-change-page="getCategories">
                <span slot="prev-nav"><i class="fas fa-angle-left"></i></span>
                <span slot="next-nav"><i class="fas fa-angle-right"></i></span>
            </pagination>
        </template>
    </table-extend>
</template>

<script>
     import { mapGetters } from "vuex"
    import TableEx from "./extensions/Table.vue"

    export default {
        name:"CategoriesTable",
        data(){
            return {
                limit:2,
                categories:{},
                fetch:false,
            }
        },
        computed:{
            ...mapGetters(["categoriesRoutes"]),
            fetching(){return this.fetch}
        },
        components:{
            "table-extend":TableEx,
        },
        mounted(){
            this.getCategories();
            Fire.$on('ReloadCategories',() => {
               this.getCategories();
            });
        },
        methods:{
            emitCurr(category){
                Fire.$emit("SetCurrentCategory",category);
            },
            loadCategories(url){
                this.fetch = true;
                $("body").get(0).scrollIntoView();
                axios.get(url).then((response)=>{
                    this.fetch = false;
                    this.categories = response.data;
                }).catch(()=>{
                    new toast({
                        type: 'error',
                        title: this.$t('categoryTableError'),
                    });
                    this.fetch = false;
                })
            },
            getCategories(page = 1) {
                this.loadCategories(this.categoriesRoutes.paginate + page);
            },
            viewModal(id){
                axios.get(this.categoriesRoutes.show+id).then((response)=>{
                    this.category = response.data.data;
                    $('#view').modal('show');
                }).catch({});
            },
            emitUpdate(category){
                Fire.$emit("BeforeUpdateCategory",category);
            },
            emitDelete(id){
                new swal({
                    title: this.$t('deleteConfirmTitle'),
                    text: this.$t('deleteConfirmText'),
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: this.$t('deleteConfirmButton')
                }).then((result) => {
                    if (result.value) {
                        Fire.$emit("DeleteCategory",id)
                    }
                })
            },
        }
    }
</script>
