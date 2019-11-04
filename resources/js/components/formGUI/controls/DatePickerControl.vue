<template>
    <div>
        <div class="form-group row datePickerControl" v-if="labelPosition === 'left'">
            <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline} + ' col-sm-4 col-form-label'">
                {{control.label}}
            </label>
            <div class="col-sm-8">
                <input type="date"
                   class="form-control"
                   :readonly="this.control.readonly"
                   :name="control.fieldName"
                   v-model="control.value" />
           </div>
        </div>

        <div class="form-group" v-else>
            <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}">
                {{control.label}}
            </label>

            <input type="date"
               class="form-control"
               :readonly="this.control.readonly"
               :name="control.fieldName"
               v-model="control.value" />
        </div>
    </div>
</template>

<script>
    import {CONTROL_CONSTANTS} from "../config/constants";
    export default {
        name: "DatePickerControl",
        props:['propControl', 'labelPosition'],
        data: () => ({
            control: {type: Object},
            options: {
            },
        }),
        created() {
            this.control= this.propControl;
            // set date format
            this.options.dateFormat = this.control.dateFormat;

            // if this control already have value, set it (value => default value => settings)
            if (!_.isEmpty(this.control.value)) {
                return; // stop
            }

            // default value
            if (!_.isEmpty(this.control.defaultValue)) {
                this.control.value = this.control.defaultValue;
                return;
            }

            // today value or not
            if (this.control.isTodayValue) {
                this.control.value = (moment().format(CONTROL_CONSTANTS.DateFormat[this.control.dateFormat]));
            }
        },
        mounted() {
            this.control= this.propControl;
        }
    }
</script>

<style scoped>
</style>
