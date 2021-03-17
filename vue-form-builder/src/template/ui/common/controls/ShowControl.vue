<!--
/**
* Description:
* VueJS Show Action Buttons Control (backend)
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
        <div class="controlItem p-2" :id="control.name">
            <label>Show Action Buttons</label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ShowControl",
        props: ['control'],
        methods: {
            removeItem: function(name) {
                this.$emit('removeItem', name);
            }
        }
    }
</script>

<style scoped>

</style>
