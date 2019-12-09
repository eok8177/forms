<template>
    <div>
        <div class="row" v-if="labelPosition === 'left'" :class="value.cssClass">
            <div class="col-md-4">
                <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
            </div>
            <div class="col-md-8">
                <div class="custom-control custom-radio custom-control-inline" v-for="(option, index) in value.dataOptions">
                  <input type="radio" 
                  v-model="value.value"
                  :id="value.name + index" 
                  :name="value.fieldName" 
                  :value="option.id" 
                  class="custom-control-input">

                  <label class="custom-control-label" :for="value.name + index" :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}">{{option.text}}</label>
                </div>
            </div>
        </div>

        <div class="form-group" v-else :class="value.cssClass">
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>

            <div class="custom-control custom-radio" v-for="(option, index) in value.dataOptions">
              <input type="radio" 
              v-model="value.value"
              :id="value.name + index" 
              :name="value.fieldName" 
              :value="option.id" 
              class="custom-control-input">

              <label class="custom-control-label" :for="value.name + index" :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}">{{option.text}}</label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RadioControl",
        props:['value', 'labelPosition'],
        data: () => ({
            dataSource: [],
        }),
        created() {
            // request for ajax source
            this.dataSource = this.value.dataOptions;
        },
        mounted() {
            if (!_.isEmpty(this.value.defaultValue)) {
                if (this.value.isMultiple) {
                    this.value.value = [this.value.defaultValue];
                } else {
                    this.value.value = this.value.defaultValue;
                }
            }
        }
    }
</script>

<style scoped>

</style>
