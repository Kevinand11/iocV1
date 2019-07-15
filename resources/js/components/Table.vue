<template>
    <div>
        <table class="table table-striped table-hover">
            <thead>
                <slot name="headers"></slot>
            </thead>
            <slot name="rows"></slot>
        </table>
        <slot name="pagination"></slot>
    </div>
</template>

<script>
    export default {
        name: "Table"
    }
</script>