<!--
/**
* Description:
* VueJS Row Component (frontend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div class="mt-2">
        <div class="sub-header" v-html="value.subHeader"></div>

        <div class="col-md-12 rowItem" v-if="value.isDynamic">

            <div class="rowDynamicItem" v-for="(instance, index) in value.instances" :key="index" :class="'rowDynamic_' + index">
                <div class="float-right" v-if="!admin">
                    <button type="button" class="remove btn danger" @click="removeDynamicObj(index)">delete</button>
                </div>

                <hr  v-if="index > 0">

                <div class="row" v-for="row in instance">
                    <control-component v-for="control in row.controls"
                                       :key="control.name + index"
                                       :control="control"
                                       :label-position="value.labelPosition">
                    </control-component>
                </div>
            </div>

            <div class="text-right mb-4" v-if="!admin">
                <button type="button" class="add btn success" @click="addDynamicObj">add new</button>
            </div>
        </div>

        <div class="row rowItem" v-if="!value.isDynamic" v-for="row in value.rows">
            <control-component v-for="control in row.controls"
                               :key="control.name"
                               :control="control"
                               :label-position="value.labelPosition">
            </control-component>
        </div>

        <div class="sub-footer" v-html="value.subFooter"></div>

    </div>
</template>

<script>
    import ControlComponent from "./ControlComponent";

    export default {
        name: "RowComponent",
        components: {ControlComponent},
        props: ['value', 'index'],
        data: () => ({
            dynamicTemplate: null,
            instances: {type: Object},
            admin: false,
        }),
        methods: {
            addDynamicObj() {
                if (this.value.maxInstance > 0 && this.value.instances.length === this.value.maxInstance) {
                    console.log("Maximum instances reached, can't create more.");
                    return;
                }

                //set unique fieldName to cloned items
                let template = _.cloneDeep(this.dynamicTemplate);
                let i = Object.keys(this.instances).length;
                _.forEach(template, function(row, rowKey) {
                    _.forEach(row.controls, function(control, controlKey) {

                        // add modificator to Name & set dynamicControl flag
                        let modName = '_d'+i;
                        template[rowKey].controls[controlKey].modName = modName;
                        template[rowKey].controls[controlKey].dynamicControl = true;

                        template[rowKey].controls[controlKey].name += modName;
                        template[rowKey].controls[controlKey].fieldName += modName;
                    });
                });

                this.instances.push(template);
                //Update parent object instances field
                this.$parent.$parent.updateInstances(this.index, this.instances);
            },
            removeDynamicObj(index) {
                if (this.value.minInstance === this.value.instances.length) {
                    console.log("Minimum instances reached, can't remove more.");
                    return;
                }
                this.instances.splice(index, 1);
                //Update parent object instances field
                this.$parent.$parent.updateInstances(this.index, this.instances);
            },
            generateDynamic() {
                if (this.value.isDynamic) {
                    // generate dynamic template
                    this.dynamicTemplate = _.cloneDeep(this.value.rows);

                    if (this.value.instances.length > 0) {
                        this.instances = this.value.instances;
                    } else {
                        this.instances = [];

                        // populate min instance
                        if (this.value.minInstance > 0) {
                            for (var i = 0; i < this.value.minInstance; i++) {
                                this.addDynamicObj();
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.generateDynamic();
            this.admin = this.$parent.$parent.admin;
        }
    }
</script>

<style scoped>

</style>
