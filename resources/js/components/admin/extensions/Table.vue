<template>
    <v-container>
        <table class="table table-striped table-hover">
            <thead>
                <slot name="headers"></slot>
            </thead>
            <slot name="rows"></slot>
        </table>
        <slot name="pagination"></slot>
    </v-container>
</template>

<script>
    export default {
        name: "Table"
    }
</script>
