<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile Component</div>
            
                    <div class="card-body">
                        {{ user }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name:"Profile",
        computed:{
            ...mapGetters(['getAuth']),
            user(){ return this.getAuth }
        },
    }
</script>
