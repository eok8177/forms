<!--
/**
* Description:
* VueJS Html Config Component (backend)
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
        <div class="form-group">
            <label>Text</label>
            <textarea rows="2" class="form-control" v-model="control.text"></textarea>
        </div>
    </div>
</template>

<script>
    export default {
        name: "HtmlConfigComponent",
        props: {
            control: {
                type: Object
            },
        },
    }
</script>

<style scoped>

</style>
