<template>
  <v-footer height="auto" dark class="d-flex" :color="appInfo.color">
    <v-card flat tile class="white--text text-center" :class="appInfo.color">
        <v-card-text>
            <v-btn v-for="icon in icons" :key="icon.id" class="mx-2" icon small>
                <v-icon :color="icon.color" small>{{ icon.name }}</v-icon>
            </v-btn>
            <v-divider></v-divider>
            <strong>{{ $t('footerCopyright') }} &copy; {{ new Date().getFullYear() }} <a href="/">{{ appInfo.name }}</a>.</strong> {{ $t('footerAllRightsReserved') }}
        </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name:"Footer",
        data: () => ({
            icons: [
                {id:1, name:'fab fa-facebook', color:"white"},
                {id:2, name:'fab fa-instagram', color:"white"},
                {id:3, name:'fab fa-twitter', color:"white"},
                {id:4, name:'fab fa-whatsapp', color:"white"},
                {id:5, name:'fab fa-linkedin', color:"white"},
            ]
        }),
        computed:{
            ...mapGetters(['appInfo']),
        }
    }
</script>
