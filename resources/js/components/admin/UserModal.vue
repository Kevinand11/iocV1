<<template>
    <modal dataName="User">
        <div class="card-title" slot="name">
            <span class="lead">{{ user.name }}</span>
        </div>
        <div slot="body">
            <p class="lead">Email:{{user.email}}</p>
            <p>Phone:{{user.phone}}</p>
            <p>Role: {{ user.role }}</p>
            <p>Password:{{ user.password }}</p><hr>
            <p class="lead">Posts by {{user.name}}</p>
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
                    <tr v-for="post in user.posts" :key="post.id">
                        <td>{{post.id}}</td>
                        <td>{{post.name}}</td>
                        <td>{{post.price | addNairaSign}}</td>
                        <td>{{post.category.name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
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
        }
    }
</script>
