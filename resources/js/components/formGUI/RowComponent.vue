<template>
    <div class="mt-2">
        <div class="col-md-12 rowItem" v-if="section.isDynamic">
            <div class="float-right">
                <span class="add text-success" @click="addDynamicObj"><i class="fa fa-plus-circle"></i></span>
            </div>

            <div class="rowDynamicItem" v-for="(data, index) in section.instances" :key="index" :class="'rowDynamic_' + index">
                <div class="float-right">
                    <span class="remove text-danger" @click="removeDynamicObj(index)"><i class="fa fa-times-circle"></i></span>
                </div>

                <div class="row" v-for="row in data">
                    <control-component v-for="control in row.controls"
                                       :key="control.name + index"
                                       :control="control"
                                       :label-position="section.labelPosition">
                    </control-component>
                </div>
            </div>
        </div>

        <div class="row rowItem" v-if="!section.isDynamic" v-for="row in section.rows">
            <control-component v-for="control in row.controls"
                               :key="control.name"
                               :control="control"
                               :label-position="section.labelPosition">
            </control-component>
        </div>
    </div>
</template>

<script>
    import ControlComponent from "./ControlComponent";

    export default {
        name: "RowComponent",
        components: {ControlComponent},
        props: ['propSection'],
        data: () => ({
            dynamicTemplate: null,
            section: {type: Object},
        }),
        methods: {
            addDynamicObj() {
                if (this.section.maxInstance > 0 && this.section.instances.length === this.section.maxInstance) {
                    SethPhatToaster.error("Maximum instances reached, can't create more.");
                    return;
                }

                this.section.instances.push(_.cloneDeep(this.dynamicTemplate));
            },
            removeDynamicObj(index) {
                if (this.section.minInstance === this.section.instances.length) {
                    SethPhatToaster.error("Minimum instances reached, can't remove more.");
                    return;
                }

                this.section.instances.splice(index, 1);
            },
            generateDynamic() {
                if (this.section.isDynamic) {
                    this.section.instances = [];

                    // generate dynamic template
                    this.dynamicTemplate = _.cloneDeep(this.section.rows);

                    // populate min instance
                    if (this.section.minInstance > 0) {
                        for (var i = 0; i < this.section.minInstance; i++) {
                            this.addDynamicObj();
                        }
                    }
                }
            }
        },
        mounted() {
            this.section= this.propSection;
            this.generateDynamic();
        }
    }
</script>

<style scoped>

</style>
