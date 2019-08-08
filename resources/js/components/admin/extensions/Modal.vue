<template>
    <div>
        <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="viewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewLabel">{{ $t('modalHeader') }}{{dataName}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                <slot name="name"></slot>
                            </div>
                            <div class="card-body">
                                <slot name="body"></slot>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal">{{ $t('modalClose') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name : "UserModal",
        props : {
            "dataName": {
                type: String,
                required: true,
            },
        },
    }
</script>
