<!--
/**
* Description:
* VueJS Select Config Component (backend)
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
            <label>
                <input type="checkbox" name="isMultiple" v-model="control.isMultiple"> Multiple Select
            </label>
        </div>

        <div class="col-md-12">
            <label>Data Source</label>
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

            <div class="form-group">
                <label>Import from .csv 
                    <small>[
                    <a href="/files/select1.csv" target="_blank">example 1</a> ,
                    <a href="/files/select2.csv" target="_blank">example 2</a>
                    ]</small>
                </label>
                <input type="file" accept=".csv" @change="processFile($event)"/>
            </div>

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
            },
            processFile(event) {
                let self = this;
                let file = event.target.files[0];
                let reader = new FileReader();
                reader.onload = function () {
                  self.processData(reader.result);
                };
                // start reading the file. When it is done, calls the onload event defined above.
                reader.readAsBinaryString(file);
            },

            processData(fileText) {
                let self = this;
                let fileTextLines = fileText.split(/\r\n|\n/);
                let headers = fileTextLines[0].split(',');

                for (let i=1; i<fileTextLines.length; i++) {
                    let data = fileTextLines[i].split(',');
                    if (data.length == headers.length) {

                        let line = {};
                        for (let j=0; j<headers.length; j++) {
                            line[headers[j]] = data[j];
                        }

                        if ("Value" in line) {
                            if (line.Value) {
                                self.control.dataOptions.push(_.clone(FORM_CONSTANTS.OptionDefault));
                                let index = self.control.dataOptions.length - 1;
                                self.control.dataOptions[index].id = line.Value;

                                if ("Text" in line) {
                                    self.control.dataOptions[index].text = line.Text;
                                } else {
                                    self.control.dataOptions[index].text = line.Value;
                                }
                            }
                        }
                    }
                }

            }

        },
        mounted() {
            // add default options
            // if (this.control.dataOptions.length <= 0) {
                // this.addOption();
            // }
        },
    }
</script>

<style scoped>

</style>
