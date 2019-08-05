<template>
    <table-extend>
        <template slot="headers">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Link</th>
                <th>Phone</th>
                <th>Description</th>
                <th>Picture</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Modifiers</th>
            </tr>
        </template>
        <template slot="rows">
            <tbody>
                <v-layout row wrap v-if="fetching">
                    <v-flex xs6 offset-xs3>
                        <vue-simple-spinner message="Loading" size="large" />
                    </v-flex>
                </v-layout>
                <tr v-for="store in stores.data" :key="store.id" @click="emitCurr(store)" v-if="!fetching">
                    <td>{{store.id}}</td>
                    <td>{{store.name}}</td>
                    <td>{{store.email}}</td>
                    <td>{{store.link}}</td>
                    <td>{{store.phone.phone}}<small>{{store.phone.phone_country}}</small></td>
                    <td>{{store.description}}</td>
                    <td>{{store.picture ? store.picture.filename : 'None'}}</td>
                    <td>{{store.created_at | myDate}}</td>
                    <td>{{store.updated_at | myDate}}</td>
                    <td>
                        <a @click.prevent="viewModal(store.id)"><i class="fas fa-eye text-blue"></i></a>
                        &nbsp;|&nbsp;
                        <a @click.prevent="emitUpdate(store)"><i class="fas fa-pen text-orange"></i></a>
                        &nbsp;|&nbsp;
                        <a @click.prevent="emitDelete(store.id)"><i class="fas fa-trash text-red"></i></a>
                    </td>
                </tr>
            </tbody>
        </template>
        <template slot="pagination">
            <pagination :data="stores" align="center" :limit="limit" @pagination-change-page="getStores">
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
        name:"StoreTable",
        data(){
            return {
                limit:2,
                stores:{},
                fetch: false,
            }
        },
        computed:{
            ...mapGetters(["storesRoutes"]),
            fetching(){return this.fetch}
        },
        components:{
            "table-extend":TableEx,
        },
        mounted(){
            this.getStores();
            Fire.$on('ReloadStores',() => {
                this.getStores();
            });
        },
        methods:{
            emitCurr(store){
                Fire.$emit("SetCurrentStore",store);
            },
            loadStores(url){
                this.fetch = true;
                $("body").get(0).scrollIntoView();
                axios.get(url)
                    .then((response)=>{
                        this.fetch = false;
                        this.stores = response.data;
                    }).catch(()=>{
                    new toast({
                        type: 'error',
                        title: 'Unable to fetch data'
                    });
                    this.fetch = false;
                })
            },
            getStores(page = 1) {
                this.loadStores(this.storesRoutes.paginate + page);
            },
            viewModal(id){
                axios.get(this.storesRoutes.show+id).then((response)=>{
                    this.store = response.data.data;
                    $('#view').modal('show');
                }).catch({});
            },
            emitUpdate(store){
                Fire.$emit("BeforeUpdateStore",store);
            },
            emitDelete(id){
                new swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        Fire.$emit("DeleteStore",id)
                    }
                })
            },
        }
    }
</script>
