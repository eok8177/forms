<template>
    <div>
        <div class="row" v-if="labelPosition === 'left'">
            <div class="col-md-4">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}">
                    {{control.label}}
                </label>
            </div>
            <div class="col-md-8">
                <input type="time"
                   class="form-control"
                   :readonly="this.control.readonly"
                   :name="control.fieldName"
                   v-model="control.value" />
            </div>
        </div>
        <div v-else class="form-group">
            <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}">
                {{control.label}}
            </label>
            <input type="time"
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
        name: "TimePickerControl",
        props:['propControl', 'labelPosition'],
        data: () => ({
            control: {type: Object},
            options: {
                zindex:1111,
            }
        }),
        created() {
            this.control= this.propControl;

            // setup data
            this.options.timeFormat = this.control.timeFormat;

            if (!_.isEmpty(this.control.defaultValue)) {
                this.control.value = this.control.defaultValue;
            }

            if (this.control.isNowTimeValue) {
                this.control.value = moment().format(CONTROL_CONSTANTS.TimeFormat[this.control.timeFormat]);
            }
        }
    }
</script>

<style scoped>

</style>
