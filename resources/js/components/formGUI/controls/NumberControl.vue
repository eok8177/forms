<!--
/**
* Description:
* VueJS Number Control (frontend)
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
                <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="number"
                       class="form-control"
                       :readonly="value.readonly"
                       :name="value.fieldName"
                       :step="controlStep"
                       :required="value.required"
                       :min="value.minValue"
                       :max="value.maxValue"
                       @change="numberChange"
                       v-model="value.value"
                       @keypress="isNumber($event)" />
                </div>
            </div>
        </div>
        <div class="form-group" v-else :class="value.cssClass">
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>

            <div class="input-group">
                <input type="number"
                   class="form-control"
                   :readonly="value.readonly"
                   :name="value.fieldName"
                   :step="controlStep"
                   :required="value.required"
                   :min="value.minValue"
                   :max="value.maxValue"
                   @change="numberChange"
                   v-model="value.value"
                   @keypress="isNumber($event)" />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NumberControl",
        props: ['value', 'labelPosition'],
        created() {
            // this.value.value = 0;
        },
        mounted() {
            if (!_.isEmpty(this.value.defaultValue)) {
                this.value.value = this.value.defaultValue;
            }
            this.value.readonly = this.$parent.$parent.$parent.$parent.admin || this.value.readonly;
        },
        methods: {
            numberChange(e) {
                let val = e.target.value;

                if (!_.isEmpty(val)) {
                  if (this.value.isInteger === false) {
                      this.value.value = parseFloat(val).toFixed(this.value.decimalPlace);
                  } else {
                      this.value.value = parseInt(val);
                  }
                }

                if (!_.isEmpty(this.value.minValue) && this.value.value < this.value.minValue) this.value.value = this.value.minValue;
                if (!_.isEmpty(this.value.maxValue) && this.value.value > this.value.maxValue) this.value.value = this.value.maxValue;
            },
            isNumber(e) {
              let theEvent = e || window.event;

              // Handle paste
              if (theEvent.type === 'paste') {
                  key = event.clipboardData.getData('text/plain');
              } else {
              // Handle key press
                  var key = theEvent.keyCode || theEvent.which;
                  key = String.fromCharCode(key);
              }
              var regex = /[0-9]|\./;
              if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
              }
            }
        },
        computed: {
            controlStep() {
                return 1;
            }
        }
    }
</script>

<style scoped>

</style>
