<template>
    <div>
        <div class="custom-control custom-switch" v-if="labelPosition === 'left'">
            <input type="checkbox"
               class="custom-control-input"
               :id = "value.name + '_gui_control'"
               :readonly="value.readonly"
               :name="value.fieldName"
               v-model="value.value" />
            <label :for="value.name + '_gui_control'"
                   class="custom-control-label"
                   :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}">
                {{value.label}}
            </label>
        </div>
        <div class="form-check" v-else>
            <input type="checkbox"
               class="form-check-input"
               :id = "value.name + '_gui_control'"
               :readonly="value.readonly"
               :name="value.fieldName"
               v-model="value.value" />

            <label :for="value.name + '_gui_control'"
                   class="custom-control-label"
                   :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}">
                {{value.label}}
            </label>
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
