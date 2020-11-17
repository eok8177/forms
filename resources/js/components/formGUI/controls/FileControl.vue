<template>
    <div>
      <div class="row" v-if="labelPosition === 'left'" :class="value.cssClass">
          <div class="col-md-4">
              <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
          </div>
          <div class="col-md-8">
              <input type="file" v-if="!admin"
                     v-show="!value.value"
                     class="form-control-file"
                     :name="value.fieldName"
                     :required="value.required"
                     :accept="value.extensions"
                     :max-size="value.maxSize"
                     @change="processFile($event)"
                     />
                     <small v-if="value.extensions || value.maxSize" class="form-text text-muted">Accepted: {{value.maxSize}} {{value.extensions}}</small>
              <div v-if="typeof value.value === 'string' || value.value instanceof String">
                <a :href="'/'+value.value" target="_blank">{{getFileName()}}</a>
              </div>
          </div>
      </div>
      <div v-else class="form-group" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>

          <input type="file" v-if="!admin"
                 v-show="!value.value"
                 class="form-control-file"
                 :name="value.fieldName"
                 :required="value.required"
                 :accept="value.extensions"
                 :max-size="value.maxSize"
                 @change="processFile($event)"
                 />
                 <small v-if="value.extensions || value.maxSize" class="form-text text-muted">Accepted: {{value.maxSize}} {{value.extensions}}</small>

        <div v-if="typeof value.value === 'string' || value.value instanceof String">
         <a :href="'/'+value.value" target="_blank">{{getFileName()}}</a>
        </div>
      </div>
    </div>
</template>

<script>
    export default {
        name: "FileControl",
        props: ['value', 'labelPosition'],
        data: () => ({
            admin: false,
        }),
        mounted() {
          this.admin = this.$parent.$parent.$parent.$parent.admin;
        },
        methods: {
          processFile(event) {
            this.value.value = event.target.files[0];
          },
          getFileName() {
            return this.value.value.replace(/\w+\/\d+\/\d+\//g, "");
          }
        }
    }
</script>

<style scoped>

</style>
