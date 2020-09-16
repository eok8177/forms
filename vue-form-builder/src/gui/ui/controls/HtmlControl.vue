<template>
    <div>
        <div class="row" v-if="labelPosition === 'left'">
            <div class="col-md-4">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label"></label>
            </div>
            <div class="col-md-8">
              <div v-html="control.text"></div>
            </div>
        </div>
        <div v-else class="form-group">
            <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label"></label>

            <div v-html="control.text"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "HtmlControl",
        props: ['control', 'labelPosition'],
        mounted() {
        }
    }
</script>

<style scoped>

</style>
