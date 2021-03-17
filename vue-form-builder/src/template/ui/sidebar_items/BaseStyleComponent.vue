<!--
/**
* Description:
* VueJS Base Style Component (backend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div v-if="control.type != 'show'">
        <div class="row mt-2" v-if="control.type !== 'checkbox' && control.type !== 'address' && control.type !== 'html' && control.type !== 'file'">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Default value</label>
                    <input type="text" class="form-control" v-model="control.defaultValue">
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Control label</label>
                    <input type="text" class="form-control" v-model="control.label">
                </div>
                <div class="form-group">
                    <label><input type="checkbox" v-model="control.labelBold"> Bold</label>
                    <label><input type="checkbox" v-model="control.labelItalic"> Italic</label>
                    <label><input type="checkbox" v-model="control.labelUnderline"> Underline</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Alias</label>
            <input type="text" class="form-control" v-model="control.alias">
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Custom CSS Class</label>
                    <input type="text" class="form-control" v-model="control.cssClass">
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" v-model="control.description"></textarea>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Error message</label>
            <input type="text" class="form-control" v-model="control.errorMsg">
        </div>
    </div>
</template>

<script>
    export default {
        name: "BaseStyleComponent",
        props: {
            control: {
                type: Object
            },
        },
    }
</script>

<style scoped>

</style>
