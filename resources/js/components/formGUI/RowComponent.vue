<template>
    <div class="mt-2">
        <div class="col-md-12 rowItem" v-if="value.isDynamic">
            <div class="float-right">
                <span class="add text-success" @click="addDynamicObj"><i class="fa fa-plus-circle"></i></span>
            </div>

            <div class="rowDynamicItem" v-for="(instance, index) in value.instances" :key="index" :class="'rowDynamic_' + index">
                <div class="float-right">
                    <span class="remove text-danger" @click="removeDynamicObj(index)"><i class="fa fa-times-circle"></i></span>
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
        </div>

        <div class="row rowItem" v-if="!value.isDynamic" v-for="row in value.rows">
            <control-component v-for="control in row.controls"
                               :key="control.name"
                               :control="control"
                               :label-position="value.labelPosition">
            </control-component>
        </div>

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
                        template[rowKey].controls[controlKey].name += i;
                        template[rowKey].controls[controlKey].fieldName += i;
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
        }
    }
</script>

<style scoped>

</style>
