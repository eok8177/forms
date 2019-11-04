<template>
    <div>
        <div class="custom-control custom-switch" v-if="labelPosition === 'left'">
            <input type="checkbox"
               class="custom-control-input"
               :id = "control.name + '_gui_control'"
               :readonly="this.control.readonly"
               :name="control.fieldName"
               v-model="control.value" />
            <label :for="control.name + '_gui_control'"
                   :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline} + ' custom-control-label'">
                {{control.label}}
            </label>
        </div>
        <div class="form-check" v-else>
            <input type="checkbox"
               class="form-check-input"
               :id = "control.name + '_gui_control'"
               :readonly="this.control.readonly"
               :name="control.fieldName"
               v-model="control.value" />

            <label :for="control.name + '_gui_control'"
                   :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline} + ' form-check-label'">
                {{control.label}}
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CheckboxControl",
        props: ['propControl', 'labelPosition'],
        data: () => ({
            control: {type: Object},
        }),
        mounted() {
          this.control= this.propControl;
          if (this.control.isChecked) {
              this.control.value = true;
          }
        }
    }
</script>

<style scoped>

</style>
