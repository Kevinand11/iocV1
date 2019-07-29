<<template>
    <modal dataName="Store">
        <template class="card-title" slot="name">
            <span class="lead">{{ store.name }}</span>
        </template>
        <template slot="body">
            <p class="lead">Email:{{store.email}}</p>
            <p>Phone:{{store.phone}}</p>
            <p>Link:{{store.link}}</p>
            <p>Owner: {{store.user.name}}({{store.user.email}})({{store.user.phone}})</p>
            <p>Description: {{ store.description }}</p>
            <p>Picture: {{ store.picture }}</p>
            <p class="lead">Posts by {{store.name}}</p>
            <table class="table table-striped table-hover mb-4">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
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
