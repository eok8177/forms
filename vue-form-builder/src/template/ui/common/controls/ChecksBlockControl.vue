<!--
/**
* Description:
* VueJS Radio Control (backend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div class="controlItemWrapper" :class="control.className" :data-control-name="control.name">
        <div class="tools" @click="removeItem(control.name)"><span class="clickable fa fa-times"></span></div>
        <div class="controlItem row" :id="control.name" v-if="labelPosition === 'left'">

            <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label"></label>

            <div class="custom-control custom-checkbox custom-control-inline" v-for="(option, index) in control.dataOptions">
              <input type="checkbox" :id="control.name + index" class="custom-control-input">
              <label class="custom-control-label" :for="control.name + index" :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}">{{option.value}}</label>
            </div>

        </div>
        <div class="controlItem" :id="control.name" v-else>

            <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}" v-html="control.label"></label>
            <div>
                <div class="custom-control custom-checkbox" v-for="(option, index) in control.dataOptions">
                  <input type="checkbox" :id="control.name + index" class="custom-control-input">
                  <label class="custom-control-label" :for="control.name + index" :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}">{{option.value}}</label>
                </div>
            </div>



        </div>
    </div>
</template>

<script>

    export default {
        name: "ChecksBlockControl",
        props: ['control', 'labelPosition'],
        methods: {
            removeItem: function(name) {
                this.$emit('removeItem', name);
            }
        }
    }
</script>

<style scoped>

</style>
