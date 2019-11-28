<template>
    <div>
      <!-- <div class="row" v-if="labelPosition === 'left'"> -->
      <!-- </div> -->

      <div class="form-group">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label1"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                     :readonly="value.readonly"
                     :name="value.fieldName + '1'"
                     >
          </div>
      </div>

      <div class="form-group">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label2"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                     :readonly="value.readonly"
                     :name="value.fieldName + '2'"
                     >
          </div>
      </div>

      <div class="form-group">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label3"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                     :readonly="value.readonly"
                     :name="value.fieldName + '3'"
                     >
          </div>
      </div>

      <div class="form-group">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label4"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                     :readonly="value.readonly"
                     :name="value.fieldName + '4'"
                     >
          </div>
      </div>

    </div>
</template>

<script>
    export default {
        name: "AddressControl",
        props: ['value', 'labelPosition'],
        mounted() {
        }
    }
</script>

<style scoped>

</style>
