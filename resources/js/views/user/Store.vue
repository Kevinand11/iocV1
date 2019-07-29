<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Store Component</div>

                    <div class="card-body">
                        {{ store }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name:"Store",
        computed:{
            ...mapGetters(['getAuth']),
            store(){ return this.getAuth.store }
        },
    }
</script>
