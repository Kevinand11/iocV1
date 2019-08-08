<template>
    <modal dataName="Post">
        <template class="card-title" slot="name">
            <span class="lead">{{ post.name }}</span>
            <span class="float-right">{{ $t('postModalCategory') }}:{{ post.category.name }}</span>
        </template>
        <template slot="body">
            <p class="lead">{{post.description}}</p><hr>
            <p class="lead">{{ $t('postModalOnlyFor') }} {{ post.price | addNairaSign }}</p><hr>
            <p>
				{{ $t('postModalPostedBy') }} {{ post.store.user.name }} {{ $t('postModalPostedFrom') }} {{ post.store.name }}
                (<a :href="'tel:'+post.store.phone.phone">{{ post.store.phone.phone }}</a>)
                (<a :href="'mailto:'+post.store.email">{{ post.store.email }}</a>)
				{{ $t('postModalPostedOn') }} {{ post.created_at | myDate }}
            </p>
            <p>{{ $t('postModalLastUpdatedOn') }} {{ post.updated_at | myDate }}</p>
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
