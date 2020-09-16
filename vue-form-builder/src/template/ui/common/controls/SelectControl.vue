<template>
    <div class="controlItemWrapper" :class="control.className" :data-control-name="control.name">
        <div class="tools" @click="removeItem(control.name)"><span class="clickable fa fa-times"></span></div>
        <div class="controlItem row" :id="control.name" v-if="labelPosition === 'left'">
            <div class="col-md-4">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label"></label>
            </div>
            <div class="col-md-8 input-group">
                <select class="form-control" v-if="control.type == 'select'" :name="control.fieldName">
                    <option disabled selected>Options</option>
                    <option v-for="option in control.dataOptions">{{option.text}}</option>
                </select>
            </div>
        </div>
        <div class="controlItem row" :id="control.name" v-else>
            <div class="form-group col-md-12">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label"></label>
                <div class="input-group">
                    <select class="form-control" v-if="control.type == 'select'" :name="control.fieldName">
                        <option disabled selected>Options</option>
                        <option v-for="option in control.dataOptions">{{option.text}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "SelectControl",
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
