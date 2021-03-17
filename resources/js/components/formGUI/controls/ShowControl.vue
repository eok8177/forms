<!--
/**
* Description:
* VueJS Show Action Buttons Control (frontend)
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
    </div>
</template>

<script>
    export default {
        name: "ShowControl",
        props: ['value'],
        // Toggle Action Buttons
        mounted() {
          this.$parent.$parent.$parent.$parent.showActionButtons = true;
        },
        beforeDestroy() {
          this.$parent.$parent.$parent.$parent.showActionButtons = false;
        }
    }
</script>

<style scoped>

</style>
