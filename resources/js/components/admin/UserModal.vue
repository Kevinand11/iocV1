<template>
    <modal dataName="User">
        <template class="card-title" slot="name">
            <span class="lead">{{ user.name }}</span>
        </template>
        <template slot="body">
            <p class="lead">Email:{{user.email}}</p>
            <p>Phone:{{user.phone}}</p>
            <p>Role: {{ user.role }}</p>
            <p>Password:{{ user.password }}</p><hr>
            <p>Store: {{ user.store ? user.store.name : 'None' }}</p>
            <p>Picture: {{ user.picture ? user.picture.filename : 'None' }}</p>
        </template>
    </modal>
</template>

<script>
    import Modal from "../Modal.vue"

    export default {
        name:"UserModal",
        props:{
            "user":{
                type:Object,
                required:true
            }
        },
        components:{
            "modal":Modal
        },
    }
</script>
