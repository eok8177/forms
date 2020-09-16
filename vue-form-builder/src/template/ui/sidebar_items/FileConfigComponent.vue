<template>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="form-group">
                <label>Max file size</label>
                <input type="text" class="form-control" v-model="control.maxSize">
                <small class="form-text text-muted">Maximum allowed: 2MB</small>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Allowed file extensions</label>
                <input type="text" class="form-control" v-model="control.extensions">
                <small class="form-text text-muted">Separated with commas (i.e: .jpg, .gif, .png, .pdf)</small>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FileConfigComponent",
        props: {
            control: {
                type: Object
            },
        },
    }
</script>

<style scoped>

</style>
