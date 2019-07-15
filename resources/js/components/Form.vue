<template>
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="formLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formLabel" v-if="mode == 'create'">Add New {{dataName}}</h5>
                <h5 class="modal-title" id="formLabel" v-if="mode == 'edit'">Update {{dataName}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="submit">
                <div class="modal-body">
                    <slot name="inputFields"></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" v-if="mode=='create'">Create</button>
                    <button type="submit" class="btn btn-primary" v-if="mode=='edit'">Update</button>
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
        methods: {
            submit(){
                if(this.mode == "create"){
                    Fire.$emit('Create'+this.dataName);
                }else{
                    Fire.$emit('Update'+this.dataName);
                }
            }
        },
    }
</script>