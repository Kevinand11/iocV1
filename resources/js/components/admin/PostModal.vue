<template>
    <modal dataName="Post">
        <template class="card-title" slot="name">
            <span class="lead">{{ post.name }}</span>
            <span class="float-right">Category:{{post.category.name}}</span>
        </template>
        <template slot="body">
            <p class="lead">{{post.description}}</p><hr>
            <p class="lead">Only for #{{ post.price }}</p><hr>
            <p>
                Posted by {{post.store.user.name}} from {{post.store.name}}
                (<a :href="'tel:'+post.store.phone">{{post.store.phone}}</a>)
                (<a :href="'mailto:'+post.store.email">{{post.store.email}}</a>)
                on {{post.created_at | myDate}}
            </p>
            <p>Last updated on {{post.updated_at|myDate}}</p>
        </template>
    </modal>
</template>

<script>
    import Modal from "./extensions/Modal.vue"

    export default {
        name:"PostModal",
        props:{
            "post":{
                type:Object,
                required:true
            },
        },
        components:{
            "modal":Modal
        },
    }
</script>
