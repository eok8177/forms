<template>
    <div>
      <div class="row" v-if="labelPosition === 'left'" :class="value.cssClass">
          <div class="col-md-4">
              <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
          </div>
          <div class="col-md-8">
              <input type="file"
                     class="form-control-file"
                     :name="value.fieldName"
                     :required="value.required"
                     @change="processFile($event)"
                     />
              <a v-if="value.value" :href="'/'+value.value" target="_blank">Already uploaded file</a>
          </div>
      </div>
      <div v-else class="form-group" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>

          <input type="file"
                 class="form-control-file"
                 :name="value.fieldName"
                 :required="value.required"
                 @change="processFile($event)"
                 />
          <a v-if="value.value" :href="'/'+value.value" target="_blank">Already uploaded file</a>
      </div>
    </div>
</template>

<script>
    export default {
        name: "FileControl",
        props: ['value', 'labelPosition'],
        mounted() {
        },
        methods: {
          processFile(event) {
            this.value.value = event.target.files[0];
          }
        }
    }
</script>

<style scoped>

</style>
