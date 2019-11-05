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
                    SethPhatToaster.error("Maximum instances reached, can't create more.");
                    return;
                }
                this.instances.push(_.cloneDeep(this.dynamicTemplate));
                //Update parent object instances field
                this.$parent.updateInstances(this.index, this.instances);
            },
            removeDynamicObj(index) {
                if (this.value.minInstance === this.value.instances.length) {
                    SethPhatToaster.error("Minimum instances reached, can't remove more.");
                    return;
                }
                this.instances.splice(index, 1);
                //Update parent object instances field
                this.$parent.updateInstances(this.index, this.instances);
            },
            generateDynamic() {
                if (this.value.isDynamic) {
                    this.instances = [];

                    // generate dynamic template
                    this.dynamicTemplate = _.cloneDeep(this.value.rows);

                    // populate min instance
                    if (this.value.minInstance > 0) {
                        for (var i = 0; i < this.value.minInstance; i++) {
                            this.addDynamicObj();
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
