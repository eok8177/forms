<template>
    <div>
        <div class="row" v-if="labelPosition === 'left'">

            <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label"></label>

            <div class="custom-control custom-radio custom-control-inline" v-for="(option, index) in control.dataOptions">
              <input type="radio" class="custom-control-input"
                :id="control.name + index + '_gui'" 
                :value="option.id" 
                v-model="control.value" 
                :disabled="control.readonly">

              <label class="custom-control-label" :for="control.name + index + '_gui'">{{option.text}}</label>
            </div>

        </div>
        <div class="form-group" v-else>
            <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label"></label>

            <div class="custom-control custom-radio custom-control-inline" v-for="(option, index) in control.dataOptions">
              <input type="radio"
              :id="control.name + index + '_gui'"
              :value="option.id"
              class="custom-control-input"
              v-model="control.value"
              :disabled="control.readonly">

              <label class="custom-control-label" :for="control.name + index + '_gui'">{{option.text}}</label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RadioControl",
        props:['control', 'labelPosition'],
    }
</script>

<style scoped>

</style>
