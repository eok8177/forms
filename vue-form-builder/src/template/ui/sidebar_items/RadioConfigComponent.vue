<template>
    <div class="row mt-2">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center" width="10%">
                        <font-awesome-icon icon="plus" class="clickable" @click="addOption"></font-awesome-icon>
                    </th>
                    <th>Text</th>
                    <th width="40%">Value</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(option, index) in control.dataOptions" :class="'staticSource_' + index">
                    <td class="text-center">
                        <font-awesome-icon icon="times" class="clickable" @click="removeOption(index)"></font-awesome-icon>
                    </td>
                    <td>
                        <input type="text" class="form-control txtText" v-model="option.text">
                    </td>
                    <td>
                        <input type="text" class="form-control txtId" v-model="option.id" @change="setText(index)">
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
        name: "SelectConfigComponent",
        components: {FontAwesomeIcon},
        props: {
            control: {
                type: Object
            },
        },
        methods: {
            addOption() {
                this.control.dataOptions.push(_.clone(FORM_CONSTANTS.OptionDefault));
            },
            removeOption(index) {
                this.control.dataOptions.splice(index, 1);
            },
            setText(index) {
                if (!this.control.dataOptions[index].text) {
                    this.control.dataOptions[index].text = this.control.dataOptions[index].id;
                }
            }
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
