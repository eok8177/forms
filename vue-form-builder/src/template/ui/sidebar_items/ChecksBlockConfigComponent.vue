<!--
/**
* Description:
* VueJS Radio Config Component (backend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div class="row mt-2">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center" width="10%">
                        <font-awesome-icon icon="plus" class="clickable" @click="addOption"></font-awesome-icon>
                    </th>
                    <th>Title</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(option, index) in control.dataOptions" :class="'staticSource_' + index">
                    <td class="text-center">
                        <font-awesome-icon icon="times" class="clickable" @click="removeOption(index)"></font-awesome-icon>
                    </td>
                    <td>
                        <input type="text" class="form-control txtText" v-model="option.value">
                    </td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>
</template>

<script>
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import {FORM_CONSTANTS} from "sethFormBuilder/config/constants";

    export default {
        name: "ChecksBlockConfigComponent",
        components: {FontAwesomeIcon},
        props: {
            control: {
                type: Object
            },
        },
        methods: {
            addOption() {
                this.control.dataOptions.push({
                    value: ""
                });
            },
            removeOption(index) {
                this.control.dataOptions.splice(index, 1);
            },
        },
        mounted() {
            // add default options
            if (this.control.dataOptions.length <= 0) {
                this.addOption();
            }
        },
    }
</script>

<style scoped>

</style>
