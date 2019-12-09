<template>
    <div>
        <div class="custom-control custom-switch" v-if="labelPosition === 'left'" :class="value.cssClass">
            <input type="checkbox"
               class="custom-control-input"
               :id = "value.name + '_gui_control'"
               :readonly="value.readonly"
               :name="value.fieldName"
               :required="value.required"
               value="1"
               v-model="value.value" />
            <label :for="value.name + '_gui_control'"
                   class="custom-control-label"
                   :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}"
                   v-html="value.label">
            </label>
            <span v-if="value.required" style="color:red;">*</span>
        </div>
        <div class="form-check" v-else :class="{'required':value.required}" :class="value.cssClass">
            <input type="checkbox"
               class="form-check-input"
               :id = "value.name + '_gui_control'"
               :readonly="value.readonly"
               :name="value.fieldName"
               value="1"
               v-model="value.value" />

            <label :for="value.name + '_gui_control'"
                   class="form-check-label"
                   :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}"
                   v-html="value.label">
            </label>
            <span v-if="value.required" style="color:red;">*</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CheckboxControl",
        props: ['value', 'labelPosition'],
        mounted() {
          if (this.value.isChecked) {
              this.value.value = true;
          }
        }
    }
</script>

<style scoped>

</style>
