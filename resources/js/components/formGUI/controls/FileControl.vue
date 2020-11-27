<template>
    <div>
      <div class="row" v-if="labelPosition === 'left'" :class="value.cssClass">
          <div class="col-md-4">
              <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
          </div>
          <div class="col-md-8">
              <input type="file" v-if="!admin"
                     class="form-control-file"
                     :name="value.fieldName"
                     :required="value.required"
                     :accept="value.extensions"
                     :max-size="value.maxSize"
                     @change="processFile($event)"
                     />
                     <small v-if="value.extensions || value.maxSize" class="form-text text-muted">
                         <span v-if="value.extensions">Accepted file types: {{value.extensions}}</span>
                         <span v-if="value.extensions && value.maxSize">, </span>
                         <span v-if="value.maxSize">Max file size: {{value.maxSize}}MB</span>
                     </small>
              <div v-if="typeof value.value === 'string' || value.value instanceof String" class="link-file">
                <a :href="'/'+value.value" target="_blank">{{getFileName()}}</a>
                <button v-if="!admin" class="btn-delete" @click="deleteFile()">x</button>
              </div>
              <div class="text-danger error-msg" v-if="msg">{{msg}}</div>
          </div>
      </div>
      <div v-else class="form-group" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>

          <input type="file" v-if="!admin"
                 class="form-control-file"
                 :name="value.fieldName"
                 :required="value.required"
                 :accept="value.extensions"
                 :max-size="value.maxSize"
                 @change="processFile($event)"
                 />
                 <small v-if="value.extensions || value.maxSize" class="form-text text-muted">Accepted: {{value.extensions}}  max {{value.maxSize}}MB</small>

        <div v-if="typeof value.value === 'string' || value.value instanceof String" class="link-file">
         <a :href="'/'+value.value" target="_blank">{{getFileName()}}</a>
         <button v-if="!admin" class="btn-delete" @click="deleteFile()">x</button>
        </div>
        <div class="text-danger error-msg" v-if="msg">{{msg}}</div>
      </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "FileControl",
        props: ['value', 'labelPosition'],
        data: () => ({
            admin: false,
            msg: '',
        }),
        mounted() {
          this.admin = this.$parent.$parent.$parent.$parent.admin;
        },
        methods: {
          processFile(event) {
            this.value.value = event.target.files[0];

            if (!this.checkFileType(event)) {
              event.target.value = '';
              this.value.value = '';
              return;
            }

            if (!this.checkFileSize(event)) {
              event.target.value = '';
              this.value.value = '';
              return;
            }
          },
          getFileName() {
            return this.value.value.replace(/\w+\/\d+\/\d+\//g, "");
          },
          checkFileSize(e)
          {
            this.msg = '';
            let valid = false;

            let maxSize = this.value.maxSize || 2;
            let size = e.target.files[0].size/1024/1024;

            if (parseFloat(size) <= parseFloat(maxSize)) valid = true;

            if (!valid) this.msg = 'File size is too large';
            return valid;
          },
          checkFileType(e)
          {
            this.msg = '';
            let valid = false;

            // rule not has ext
            if (!this.value.extensions) return true;

            let name = e.target.files[0].name;
            let ext = name.match(/\.([^\.]+)$/)[1];
            ext = '.' + ext;

            if (this.value.extensions) {
              this.value.extensions.split(',').forEach(function(item) {
                if (item == ext) valid = true;
              });
            }

            if (!valid) this.msg = 'Wrong file type';
            return valid;
          },

          deleteFile() {
            axios.post('/api/delete-file', {
                file: this.value.value,
                appid: this.$parent.$parent.$parent.$parent.appid
              })
              .then(
                (response) => {
                  this.value.value = false;
                  this.$parent.$parent.$parent.$parent.SaveApps(true);
                }
              )
              .catch(
                (error) => console.log(error)
              );
          }
        }
    }
</script>

<style scoped>
  .link-file {
    padding-top: 10px;
  }
  .btn-delete {
    background: transparent;
    color: red;
    border: none;
    outline: none;
    margin-left: 16px;
  }

</style>
