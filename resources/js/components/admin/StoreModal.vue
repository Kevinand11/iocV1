<<template>
    <modal dataName="Store">
        <template class="card-title" slot="name">
            <span class="lead">{{ store.name }}</span>
        </template>
        <template slot="body">
            <p class="lead">{{ $t('storeModalEmail') }}:{{ store.email }}</p>
            <p>{{ $t('storeModalPhone') }}:{{ store.phone.phone }}<small>{{ store.phone.phone_country }}</small></p>
            <p>{{ $t('storeModalLink') }}:{{ store.link }}</p>
            <p>{{ $t('storeModalOwner') }}: {{ store.user.name }}({{ store.user.email }})({{ store.user.phone.phone }})</p>
            <p>{{ $t('storeModalDescription') }}: {{ store.description }}</p>
            <p>{{ $t('storeModalPictureName') }}: {{ store.picture ? store.picture.filename : $t('storeModalNone') }}</p>
            <p class="lead">{{ $t('storeModalPostsBy') }} {{store.name}}</p>
            <table class="table table-striped table-hover mb-4">
                <thead>
                    <tr>
                        <th>{{ $t('postTableId') }}</th>
                        <th>{{ $t('postTableName') }}</th>
                        <th>{{ $t('postTablePrice') }}</th>
                        <th>{{ $t('postTableCategory') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in store.posts" :key="post.id">
                        <td>{{post.id}}</td>
                        <td>{{post.name}}</td>
                        <td>{{post.price | addNairaSign}}</td>
                        <td>{{post.category.name}}</td>
                    </tr>
                </tbody>
            </table>
        </template>
    </modal>
</template>

<script>
    import Modal from "./extensions/Modal.vue"

    export default {
        name:"StoreModal",
        props:{
            "store":{
                type:Object,
                required:true
            }
        },
        components:{
            "modal":Modal
        }
    }
</script>
