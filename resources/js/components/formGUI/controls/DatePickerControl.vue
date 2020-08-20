<template>
    <div>
        <div class="form-group row datePickerControl" v-if="labelPosition === 'left'" :class="value.cssClass">
            <label class="col-sm-4 col-form-label" :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
            <div class="col-sm-8">
                <input type="text"
                   class="form-control"
                   data-type="datepicker"
                   :id = "value.name"
                   :readonly="value.readonly"
                   :name="value.fieldName"
                   :required="value.required"
                   v-model="value.value" />
           </div>
        </div>

        <div class="form-group" v-else :class="value.cssClass">
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>

            <input type="text"
               class="form-control"
               data-type="datepicker"
               :id = "value.name"
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
        name: "DatePickerControl",
        props:['value', 'labelPosition'],
        data: () => ({
            options: {},
        }),
        created() {
            // set date format
            this.options.dateFormat = DATE_FORMAT;

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
                // this.value.value = (moment().format(CONTROL_CONSTANTS.DateFormat[this.value.dateFormat]));
            }
            //ToDo sceck default value
            // console.log(this.value);

        },
        mounted() {
          this.value.readonly = this.$parent.$parent.$parent.$parent.admin;
          let self = this;
          let optionsDate = {
            format: self.options.dateFormat,
          };
          if(self.value.maxDate) {
            optionsDate['endDate'] = self.dateDiff(self.value.maxDate);
          }
          if(self.value.minDate) {
            optionsDate['startDate'] = self.dateDiff(self.value.minDate);
          }
          if(self.value.isTodayValue) {
            optionsDate['todayHighlight'] = true;
          }
          if (!self.value.readonly) {
            $('#'+this.value.name).datepicker(optionsDate)
                .on('changeDate', function(e) {
                    self.value.value = e.format(self.options.dateFormat);
                });
          }
        },
        methods: {
          dateDiff(stringDate) {

            let [day, month, year] = stringDate.split("\/");
            let incDate = new Date(year, month - 1, day);

            let now = new Date();
            now.setHours(0,0,0,0);

            let millisecondsPerDay = 1000 * 60 * 60 * 24;
            let millisBetween = incDate.getTime() - now.getTime();

            let days = millisBetween / millisecondsPerDay;

            let shift = Math.ceil(days);
            if (shift >= 0) shift = '+'+shift;

            return shift + 'd';
          }
        }
    }
</script>

<style scoped>
</style>
