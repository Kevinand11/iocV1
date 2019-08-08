<template>
    <modal dataName="User">
        <template class="card-title" slot="name">
            <span class="lead">{{ user.name }}</span>
        </template>
        <template slot="body">
            <p class="lead">{{ $t('userModalEmail') }}:{{ user.email }}</p>
			<p>{{ $t('userModalPhone') }}:{{ user.phone.phone }}<small>{{ user.phone.phone_country }}</small></p>
            <p>{{ $t('userModalRole') }}: {{ user.role }}</p>
            <p>{{ $t('userModalStore') }}: {{ user.store ? user.store.name : $t('userModalNone') }}</p>
            <p>{{ $t('userModalPictureName') }}: {{ user.picture ? user.picture.filename : $t('userModalNone') }}</p>
        </template>
    </modal>
</template>

<script>
    import Modal from "./extensions/Modal.vue"

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
