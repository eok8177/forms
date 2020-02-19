<template>
    <div>
        <div :class="value.cssClass">
            <div class="form-group form-check">
              <input type="checkbox"
                 class="custom-check-input"
                 id="agree"
                 :name="value.fieldName"
                 :required="value.required"
                 value="1"
                 :disabled="admin"
                 v-model="value.value" />
              <label class="form-check-label" for="agree" 
                :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}"
                v-html="value.label"></label>
                <a href="#dataModal" type="button" data-toggle="modal" data-target="#dataModal" @click="parseForm()">View data</a>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "AllFieldsControl",
        props:['value', 'labelPosition'],
        data: () => ({
            admin: false,
        }),
        methods: {
          parseForm() {
              this.$parent.$parent.$parent.$parent.parseForm(-1);
          }
        },
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
