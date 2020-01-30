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
                       class="form-control"
                       :readonly="value.readonly"
                       v-if="!value.isMultiLine"
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
                   class="form-control"
                   :readonly="value.readonly"
                   v-if="!value.isMultiLine"
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
    export default {
        name: "TextControl",
        props: ['value', 'labelPosition'],
        mounted() {
            if (!_.isEmpty(this.value.defaultValue)) {
                this.value.value = this.value.defaultValue;
            }
        }
    }
</script>

<style scoped>

</style>
