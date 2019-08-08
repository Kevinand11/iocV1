<template>
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="formLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formLabel">
                    <span v-if="mode==='create'">{{ $t('formAddNewHeader') }}</span>
                    <span v-if="mode==='edit'">{{ $t('formUpdateHeader') }}</span>
                    <span> {{ dataName }}</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="submit" method="POST">
                <div class="modal-body">
                    <slot name="inputFields"></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('formCancel') }}</button>
                    <button type="submit" class="btn btn-primary" :disabled="isDisabled">
                        <span v-if="!isDisabled && mode==='create'">{{ $t('formBtnCreate') }}</span>
                        <span v-if="!isDisabled && mode==='edit'">{{ $t('formBtnUpdate') }}</span>
                        <i class="fas fa-spinner fa-spin" v-if="isDisabled"></i>
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name : "Form",
        props : {
            "dataName": {
                type: String,
                required: true,
            },
            "mode": {
                type: String,
                required: true,
            },
        },
        data(){
            return {
                disabled:false,
            }
        },
        computed:{
            isDisabled(){return this.disabled}
        },
        mounted(){
            Fire.$on("Enable",()=>{
                this.disabled = false;
            });
        },
        methods: {
            submit(){
                this.disabled = true;
                if(this.mode === "create"){
                    Fire.$emit('Create'+this.dataName);
                }else{
                    Fire.$emit('Update'+this.dataName);
                }
            }
        },
    }
</script>
