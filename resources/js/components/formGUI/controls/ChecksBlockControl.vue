<!--
/**
* Description:
* VueJS Checkbox`s Block Control (frontend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div :id="value.fieldName">
        <div class="row" v-if="labelPosition === 'left'" :class="value.cssClass">
            <div class="col-md-8">
                <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
            </div>
            <div class="col-md-4">
                <div class="custom-control custom-checkbox custom-control-inline" v-for="(option, index) in value.dataOptions">
                  <input type="checkbox" 
                    v-model="checked"
                    :id="value.fieldName + index" 
                    :value="option.value" 
                    v-on:change="dataChanged"
                    :disabled="admin"
                    class="custom-control-input">

                  <label class="custom-control-label" :for="value.fieldName + index" :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}">{{option.value}}</label>
                </div>
            </div>
        </div>

        <div class="form-group" v-else :class="value.cssClass">
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>

            <div class="custom-control custom-checkbox" v-for="(option, index) in value.dataOptions">
              <input type="checkbox" 
                v-model="checked"
                :id="value.fieldName + index" 
                :value="option.value" 
                v-on:change="dataChanged"
                :disabled="admin"
                class="custom-control-input">

              <label class="custom-control-label" :for="value.fieldName + index" :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}">{{option.value}}</label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChecksBlockControl",
        props:['value', 'labelPosition'],
        data: () => ({
            admin: false,
            checked: [],
        }),
        created() {},
        mounted() {
            if (!_.isEmpty(this.value.value)) {
              this.checked = this.value.value;
            }
            this.admin = this.$parent.$parent.$parent.$parent.admin || this.value.readonly;
        },
        methods: {
          dataChanged() {
            if (Array.isArray(this.checked) && this.checked.length) {
              this.value.value = this.checked;
            } else {
              this.value.value = false;
            }
          }
        }
    }
</script>

<style scoped>

</style>
