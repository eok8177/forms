<!--
/**
* Description:
* VueJS Timepicker Control (frontend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div>
        <div class="row" v-if="labelPosition === 'left'" :class="value.cssClass">
            <div class="col-md-4">
                <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label"></label>
            </div>
            <div class="col-md-8">
                <input type="time"
                   class="form-control"
                   :readonly="value.readonly"
                   :name="value.fieldName"
                   :required="value.required"
                   v-model="value.value" />
            </div>
        </div>
        <div v-else class="form-group" :class="value.cssClass">
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label"></label>
            <input type="time"
               class="form-control"
               :readonly="value.readonly"
               :name="value.fieldName"
               :required="value.required"
               v-model="value.value" />
        </div>
    </div>
</template>

<script>
    import {CONTROL_CONSTANTS} from "../config/constants";
    export default {
        name: "TimePickerControl",
        props:['value', 'labelPosition'],
        data: () => ({
            options: {}
        }),
        created() {
            // setup data
            this.options.timeFormat = this.value.timeFormat;

            if (!_.isEmpty(this.value.defaultValue)) {
                this.value.value = this.value.defaultValue;
            }

            if (this.value.isNowTimeValue) {
                this.value.value = moment().format(CONTROL_CONSTANTS.TimeFormat[this.value.timeFormat]);
            }
            this.value.readonly = this.$parent.$parent.$parent.$parent.admin || this.value.readonly;
        }
    }
</script>

<style scoped>

</style>
