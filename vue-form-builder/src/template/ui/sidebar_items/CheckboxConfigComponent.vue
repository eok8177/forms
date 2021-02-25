<!--
/**
* Description:
* VueJS Checkbox Config Component (backend)
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
        <label>
            <input type="checkbox" name="isChecked" v-model="control.isChecked"> Auto Checked?
        </label>
    </div>
</template>

<script>
    export default {
        name: "CheckboxConfigComponent",
        props: {
            control: {
                type: Object
            },
        },
    }
</script>

<style scoped>

</style>
