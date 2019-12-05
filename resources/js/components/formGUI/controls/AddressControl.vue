<template>
    <div>
      <!-- <div class="row" v-if="labelPosition === 'left'"> -->
      <!-- </div> -->

      <div class="form-group" v-if="value.showMap">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.labelMap"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.valueMap"
                 :readonly="value.readonly"
                 :name="value.fieldName + 'Map'"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show1">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label1"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.value1"
                 :readonly="value.readonly"
                 :name="value.fieldName + '1'"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show2">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label2"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.value2"
                 :readonly="value.readonly"
                 :name="value.fieldName + '2'"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show3">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label3"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.value3"
                 :readonly="value.readonly"
                 :name="value.fieldName + '3'"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show4">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label4"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.value4"
                 :readonly="value.readonly"
                 :name="value.fieldName + '4'"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show5">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label5"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.value5"
                 :readonly="value.readonly"
                 :name="value.fieldName + '5'"
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
