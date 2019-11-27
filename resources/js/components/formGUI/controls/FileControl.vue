<template>
    <div>
      <div class="row" v-if="labelPosition === 'left'">
          <div class="col-md-4">
              <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
          </div>
          <div class="col-md-8">
              <input type="file"
                     class="form-control-file"
                     :name="value.fieldName"
                     :required="value.required"
                     />
          </div>
      </div>
      <div v-else class="form-group">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>

          <input type="file"
                 class="form-control-file"
                 :name="value.fieldName"
                 :required="value.required"
                 />
      </div>
    </div>
</template>

<script>
    export default {
        name: "FileControl",
        props: ['value', 'labelPosition'],
        mounted() {
        }
        //TODO get file and send it to server
    }
</script>

<style scoped>

</style>
