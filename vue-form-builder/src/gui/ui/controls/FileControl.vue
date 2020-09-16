<template>
    <div>
        <div class="row" v-if="labelPosition === 'left'">
            <div class="col-md-4">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" :for="control.name" v-html="control.label"></label>
            </div>
            <div class="col-md-8">
                <input type="file"
                       class="form-control-file"
                       :id="control.name"
                       :name="control.fieldName"
                       v-model="control.value" />
            </div>
        </div>
        <div v-else class="form-group">
            <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" :for="control.name" v-html="control.label"></label>

            <input type="file"
                   class="form-control-file"
                   :id="control.name"
                   :name="control.fieldName"
                   v-model="control.value" />
        </div>
    </div>
</template>

<script>
    export default {
        name: "FileControl",
        props: ['control', 'labelPosition'],
        mounted() {
        }
    }
</script>

<style scoped>

</style>
