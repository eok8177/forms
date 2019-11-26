<template>
    <div>
        <div class="form-group row datePickerControl" v-if="labelPosition === 'left'">
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline} + ' col-sm-4 col-form-label'" v-html="value.label"></label>
            <div class="col-sm-8">
                <input type="date"
                   class="form-control"
                   :readonly="value.readonly"
                   :name="value.fieldName"
                   v-model="value.value" />
           </div>
        </div>

        <div class="form-group" v-else>
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label"></label>

            <input type="date"
               class="form-control"
               :readonly="value.readonly"
               :name="value.fieldName"
               v-model="value.value" />
        </div>
    </div>
</template>

<script>
    import {CONTROL_CONSTANTS} from "../config/constants";
    export default {
        name: "DatePickerControl",
        props:['value', 'labelPosition'],
        data: () => ({
            options: {},
        }),
        created() {
            // set date format
            this.options.dateFormat = this.value.dateFormat;

            // if this control already have value, set it (value => default value => settings)
            if (!_.isEmpty(this.value.value)) {
                return; // stop
            }

            // default value
            if (!_.isEmpty(this.value.defaultValue)) {
                this.value.value = this.value.defaultValue;
                return;
            }

            // today value or not
            if (this.value.isTodayValue) {
                this.value.value = (moment().format(CONTROL_CONSTANTS.DateFormat[this.value.dateFormat]));
            }
            //ToDo sceck default value
            // console.log(this.value);
        }
    }
</script>

<style scoped>
</style>
