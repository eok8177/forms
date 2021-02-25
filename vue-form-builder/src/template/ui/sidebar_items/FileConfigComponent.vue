<!--
/**
* Description:
* VueJS File Config Component (backend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="form-group">
                <label>Max file size</label>
                <input type="text" class="form-control" v-model="control.maxSize">
                <small class="form-text text-muted">Maximum allowed size: 2MB. Specify only numerical value.</small>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Allowed file extensions</label>
                <input type="text" class="form-control" v-model="control.extensions">
                <small class="form-text text-muted">Separated by comma (i.e: .jpg,.gif,.png,.pdf)</small>
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
