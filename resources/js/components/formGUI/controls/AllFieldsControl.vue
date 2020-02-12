<template>
    <div>
        <div :class="value.cssClass">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="agree">
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
        methods: {
          parseForm() {
              this.$parent.$parent.$parent.$parent.parseForm(-1);
          }
        }
    }
</script>

<style scoped>

</style>
