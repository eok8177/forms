<template>
    <div class="controlItemWrapper" :class="control.className" :data-control-name="control.name">
        <div class="tools" @click="removeItem(control.name)"><span class="clickable fa fa-times"></span></div>

        <!-- <div class="controlItem row" :id="control.name" v-if="labelPosition === 'left'"> -->
        <!-- </div> -->
        <div class="controlItem px-3" :id="control.name">

            <!-- <div class="form-group d-flex" v-if="control.showMap">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.labelMap" class="w-50"></label>
                <div class="input-group">
                    <input type="text" class="form-control"
                           :readonly="control.readonly"
                           :name="control.fieldName + '1'"
                           >
                </div>
            </div> -->

            <div class="form-group d-flex" v-if="control.show1">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label1" class="w-50"></label>
                <div class="input-group">
                    <input type="text" class="form-control"
                           :readonly="control.readonly"
                           :name="control.fieldName + '1'"
                           >
                </div>
            </div>

            <div class="form-group d-flex" v-if="control.show2">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label2" class="w-50"></label>
                <div class="input-group">
                    <input type="text" class="form-control"
                           :readonly="control.readonly"
                           :name="control.fieldName + '2'"
                           >
                </div>
            </div>

            <div class="form-group d-flex" v-if="control.show3">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label3" class="w-50"></label>
                <div class="input-group">
                    <input type="text" class="form-control"
                           :readonly="control.readonly"
                           :name="control.fieldName + '3'"
                           >
                </div>
            </div>

            <div class="form-group d-flex" v-if="control.show4">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label4" class="w-50"></label>
                <div class="input-group">
                    <input type="text" class="form-control"
                           :readonly="control.readonly"
                           :name="control.fieldName + '4'"
                           >
                </div>
            </div>

            <div class="form-group d-flex" v-if="control.show5">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label5" class="w-50"></label>
                <div class="input-group">
                    <input type="text" class="form-control"
                           :readonly="control.readonly"
                           :name="control.fieldName + '5'"
                           >
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "AddressControl",
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
