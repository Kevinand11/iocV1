<template>
    <modal dataName="Post">
        <div class="card-title" slot="name">
            <span class="lead">{{ post.name }}</span>
            <span class="small float-right">Category:{{post.category.name}}</span>
        </div>
        <div slot="body">
            <p class="lead">{{post.description}}</p><hr>
            <p class="lead">Only for #{{ post.price }}</p><hr>
            <p>Posted by {{post.user.name}} (<a :href="'mailto:'+post.user.email">{{post.user.email}}</a>) on {{post.created_at | myDate}}</p>
            <p>Last updated on {{post.updated_at|myDate}}</p>
        </div>
    </modal>
</template>

<script>
    import Modal from "../Modal.vue"
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