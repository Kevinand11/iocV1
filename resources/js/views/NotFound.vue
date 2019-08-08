<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $t('error404') }}</div>
                    <div class="card-body">
						{{ $t('pageNotFound') }}<i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-danger" @click="goBack">{{ $t('goBackButton') }}</button>
                        <button class="btn btn-primary float-right" @click="goHome">{{ $t('goHomeButton') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name:"NotFound",
        methods:{
            goBack(){
                this.$router.go(-1)
            },
            goHome(){
                this.$router.push("/")
            }
        }
    }
</script>
