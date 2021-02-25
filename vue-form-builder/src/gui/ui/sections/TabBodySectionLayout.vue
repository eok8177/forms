<!--
/**
* Description:
* VueJS TabBody Section Layout (backend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div :id="section.name + '_gui_body'" class="tab-pane fade" :class="{'show active': isFirst}">
        <row-component :section="section"></row-component>
    </div>
</template>

<script>
    import RowComponent from "sethFormBuilder/gui/ui/RowComponent";
    import {Hooks} from 'sethFormBuilder/gui/components/hook_lists';

    export default {
        name: "TabBodySectionLayout",
        components: {RowComponent},
        props: ['section', 'isFirst'],
        created() {
            // before hook
            Hooks.Section.beforeRegister.run(this.section);
        },
        mounted() {
            // after hook
            Hooks.Section.afterRegister.run(this.section);
        },
    }
</script>

<style scoped>

</style>
