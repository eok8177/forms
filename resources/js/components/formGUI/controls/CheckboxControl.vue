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
               :disabled="admin"
               v-model="value.value" />
            <label :for="value.name + '_gui_control'"
                   class="custom-control-label"
                   :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}"
                   v-html="value.label">
            </label>
            <span v-if="value.required" style="color:red;">*</span>
        </div>
        <div class="custom-control custom-switch" v-else :class="{'required':value.required} + value.cssClass">
            <input type="checkbox"
               class="custom-control-input"
               :id = "value.name + '_gui_control'"
               :readonly="value.readonly"
               :name="value.fieldName"
               :required="value.required"
               value="1"
               :disabled="admin"
               v-model="value.value" />

            <label :for="value.name + '_gui_control'"
                   class="custom-control-label"
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
        data: () => ({
            admin: false,
        }),
        mounted() {
          if (this.value.isChecked) {
              this.value.value = true;
          }
          this.admin = this.$parent.$parent.$parent.$parent.admin;
        }
    }
</script>

<style scoped>

</style>
