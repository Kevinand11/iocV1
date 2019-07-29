<template>
    <modal dataName="Category">
        <template class="card-title" slot="name">
            <span class="lead">{{ category.name }}</span>
            <span class="small float-right">Parent:{{category.parent}}</span>
        </template>
        <template slot="body">
            <p class="lead">Posts Under {{category.name}}</p>
            <table class="table table-striped table-hover mb-4">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Posted by</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in category.posts" :key="post.id">
                        <td>{{post.id}}</td>
                        <td>{{post.name}}</td>
                        <td>{{post.price | addNairaSign}}</td>
                        <td>{{post.store.name}}</td>
                    </tr>
                </tbody>
            </table>
        </template>
    </modal>
</template>

<script>
    import Modal from "./extensions/Modal.vue"

    export default {
        name:"CategoryModal",
        props:{
            "category":{
                type:Object,
                required:true
            }
        },
        components:{
            "modal":Modal
        }
    }
</script>
