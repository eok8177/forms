<!--
/**
* Description:
* VueJS Text Control (frontend)
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
      <div v-if="value.hidden">
        <input type="hidden"
               :readonly="value.readonly"
               :name="value.fieldName"
               v-model="value.value" />
      </div>
      <div v-else>
        <div class="row" v-if="labelPosition === 'left'" :class="value.cssClass">
            <div class="col-md-4">
                <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
            </div>
            <div class="col-md-8">
                <input :type="value.isEmail ? 'email' : 'text'"
                       ref="input"
                       class="form-control"
                       :readonly="value.readonly"
                       v-if="!value.isMultiLine"
                       v-bind:isInvalidFormat="value.isInvalidFormat"
                       :name="value.fieldName"
                       :required="value.required"
                       v-model="value.value" />
                <textarea v-else class="form-control"
                          v-model="value.value"
                          :readonly="value.readonly"
                          :required="value.required"
                          :name="value.fieldName"></textarea>
            </div>
        </div>
        <div v-else class="form-group" :class="value.cssClass">
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>

            <input :type="value.isEmail ? 'email' : 'text'"
                   ref="input"
                   class="form-control"
                   :readonly="value.readonly"
                   v-if="!value.isMultiLine"
                   v-bind:isInvalidFormat="value.isInvalidFormat"
                   :name="value.fieldName"
                   :required="value.required"
                   v-model="value.value" />
            <textarea v-else class="form-control"
                      v-model="value.value"
                      :readonly="value.readonly"
                      :required="value.required"
                      :name="value.fieldName"></textarea>
        </div>
      </div>
    </div>
</template>

<script>
  import Inputmask from "inputmask";
    export default {
        name: "TextControl",
        props: ['value', 'labelPosition'],
        mounted() {
            let self = this;
            if (!_.isEmpty(this.value.defaultValue)) {
                this.value.value = this.value.defaultValue;
            }
            if (!this.value.value && this.value.pre_filled) {
              let field = this.value.pre_filled.toUpperCase();
              if (window[field]) {
                this.value.value = window[field];
              }
            }
            this.value.readonly = this.$parent.$parent.$parent.$parent.admin || this.value.readonly;

            if (this.value.mask) {
              console.log(this.$refs.input);
              console.log(this.value.mask);
              let im = new Inputmask(this.value.mask,{"onincomplete": function(){ 
                  self.value.isInvalidFormat = true;
                }
              });
              im.mask(this.$refs.input);
            }
        }
    }
</script>

<style scoped>

</style>
