<!--
/**
* Description:
* VueJS Html Control
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div>
      <div class="row" v-if="labelPosition === 'left'" :class="value.cssClass">
          <div class="col-md-4">
              <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label"></label>
          </div>
          <div class="col-md-8">
              <div v-html="value.text"></div>
          </div>
      </div>
      <div v-else class="form-group" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label"></label>

          <div v-html="value.text"></div>
      </div>
    </div>
</template>

<script>
    export default {
        name: "HtmlControl",
        props: ['value', 'labelPosition'],
        mounted() {
        }
    }
</script>

<style scoped>

</style>
