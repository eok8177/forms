<!--
/**
* Description:
* VueJS File Control (backend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div class="controlItemWrapper" :class="control.className" :data-control-name="control.name">
        <div class="tools" @click="removeItem(control.name)"><span class="clickable fa fa-times"></span></div>

        <div class="controlItem row" :id="control.name" v-if="labelPosition === 'left'">
            <div class="col-md-4">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline, 'required': control.required}" v-html="control.label"></label>
            </div>
            <div class="col-md-8 input-group">
                <input type="file" class="form-control-file"
                       :name="control.fieldName">
            </div>
        </div>
        <div class="controlItem row" :id="control.name" v-else>
            <div class="form-group col-md-12">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline, 'required': control.required}" v-html="control.label"></label>
                <div class="input-group">
                    <input type="file" class="form-control-file"
                           :name="control.fieldName">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FileControl",
        props: ['control', 'labelPosition'],
        methods: {
            removeItem: function(name) {
                this.$emit('removeItem', name);
            }
        }
    }
</script>

<style scoped>

</style>
