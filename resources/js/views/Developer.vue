<template>
   <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
</template>

<script>
    import PassportClients from '../components/passport/Clients.vue'
    import PassportAuthorizedClients from '../components/passport/AuthorizedClients.vue'
    import PassportPersonalAccessTokens from '../components/passport/PersonalAccessTokens.vue'

    export default {
        name:"example",
        components:{
            "passport-clients" : PassportClients,
            "passport-authorized-clients" : PassportAuthorizedClients,
            "passport-personal-access-tokens" : PassportPersonalAccessTokens,
        }
    }
</script>
