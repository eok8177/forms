<template>
    <div>
        <div class="modal" id="sectionConfigModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Section Configuration</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body" v-if="section !== null">
                        <div class="form-group d-none">
                            <label>Section Client Key</label>
                            <input type="text" class="form-control" v-model="section.clientKey">
                        </div>
                        <div class="form-group">
                            <label>Label Position</label>
                            <select class="form-control" v-model="section.labelPosition">
                                <option value="left">Horizontal</option>
                                <option value="top">Vertical</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" v-model="section.isDynamic"> Is Dynamic Form?</label>
                        </div>

                        <div class="row" v-if="section.isDynamic">
                            <div class="col-md-6">
                                <label>Min instance</label>
                                <input type="number"
                                       min="0"
                                       class="form-control"
                                       data-toggle='tooltip'
                                       title="Minimum instance for dynamic section"
                                       v-model="section.minInstance">
                            </div>
                            <div class="col-md-6">
                                <label>Max instance</label>
                                <input type="number"
                                       min="0"
                                       class="form-control"
                                       data-toggle='tooltip'
                                       title="Maximum instance for dynamic section. 0 for unlimited."
                                       v-model="section.maxInstance">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <label>
                                    <input type="checkbox" name="isConditional" v-model="section.isConditional"> Is Conditional
                                </label>
                                <div class="col-md-12" v-if="section.isConditional">
                                    <div class="row">
                                        <select class="col-3 form-control form-control-sm" v-model="condition.action_type">
                                          <option value="show">Show</option>
                                          <option value="hide">Hide</option>
                                        </select>
                                        <label class="col-2"> if: </label>
                                        <select class="col-2 form-control form-control-sm" v-model="condition.logic_type">
                                          <option value="all">All</option>
                                          <option value="any">Any</option>
                                        </select>
                                        <label class="col-5"> the match:</label>
                                    </div>

                                    <div class="row mt-2" v-for="(rule, index) in condition.rules">
                                        <select class="form-control form-control-sm col-4" 
                                            v-model="condition.rules[index].fieldId" 
                                            @change="applyRule()">
                                          <optgroup :label="group.label" v-for="group in fieldsForSelect">
                                            <option :value="field.id" v-for="field in group.options">{{field.label}}</option>
                                          </optgroup>
                                        </select>

                                        <select class="form-control form-control-sm col-2" 
                                            v-model="condition.rules[index].operator" 
                                            @change="applyRule()">
                                          <option value="is">is</option>
                                          <option value="is_not">is not</option>
                                          <option value="greater">greater then</option>
                                          <option value="less">less then</option>
                                          <option value="contain">contains</option>
                                          <option value="start">starts with</option>
                                          <option value="end">ends with</option>
                                        </select>

                                        <div class="col-4 px-0">
                                            <input class="form-control form-control-sm" type="text" placeholder="value..." 
                                                v-model="condition.rules[index].value" 
                                                @change="applyRule()" 
                                                v-if="condition.rules[index].fieldId && formData[condition.rules[index].fieldId].type != 'select'">

                                            <select class="form-control form-control-sm" 
                                                v-model="condition.rules[index].value" 
                                                @change="applyRule()" 
                                                v-if="condition.rules[index].fieldId && formData[condition.rules[index].fieldId].type == 'select'">
                                              <option :value="field.id" v-for="field in formData[condition.rules[index].fieldId].dataOptions">{{field.text}}</option>
                                            </select>
                                        </div>

                                        <div class="col-2 px-2 d-flex">
                                            <span class="ml-2" @click="addRule()"><font-awesome-icon icon="plus"/></span>
                                            <span class="ml-2" @click="delRule(index)" v-if="condition.rules.length > 1"><font-awesome-icon icon="times"/></span>
                                        </div>

                                    </div>
                                    <small class="text-muted">Date format: {{DATE_FORMAT}}</small>
                                </div>

                                <hr>
                                <div class="form-group">
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" id="expandedSection" name="expanded" class="custom-control-input"  v-model="section.expanded":value="true">
                                      <label class="custom-control-label" for="expandedSection">expanded by default</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" id="collapsedSection" name="expanded" class="custom-control-input" v-model="section.expanded" :value="false">
                                      <label class="custom-control-label" for="collapsedSection">collapsed by default</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info" @click="save">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    const SECTION_ID = "#sectionConfigModal";

    export default {
        name: "SectionConfigModal",
        components: {FontAwesomeIcon},
        props:['updateSectionInfo'],
        data: () => ({
            index: null,
            section: null,
            condition: {
                action_type: 'show',
                logic_type: 'all',
                rules: [
                    {
                        fieldId: false,
                        operator: 'is',
                        value: ''
                    }
                ]
            },
            formData: {},
            fieldsForSelect: {},
            firstField: false,
            DATE_FORMAT: DATE_FORMAT
        }),
        methods: {
            openModal(sectionInfo, index) {
                this.section = _.cloneDeep(sectionInfo);
                this.index = _.clone(index);
                $(SECTION_ID).modal('show');

                this.parseForm();
                if (this.section.condition) {
                    this.condition = this.section.condition;
                } else {
                    this.condition = {
                        action_type: 'show',
                        logic_type: 'all',
                        rules: [
                            {
                                fieldId: this.firstField,
                                operator: 'is',
                                value: ''
                            }
                        ]
                    };
                }
            },
            closeModal() {
                $(SECTION_ID).modal('hide');
            },
            save() {
                if (_.isEmpty(this.section.clientKey)) {
                    this.section.clientKey = this.section.name;
                }
                // format data
                this.section.minInstance = parseInt(this.section.minInstance);
                this.section.maxInstance = parseInt(this.section.maxInstance);

                this.$emit('updateSectionInfo', this.section, this.index);
                this.closeModal();
            },


            addRule() {
                this.condition.rules.push(
                    {
                        fieldId: this.firstField,
                        operator: 'is',
                        value: ''
                    }
                );
            },
            delRule(index) {
                this.condition.rules.splice(index, 1);
                this.section.condition = this.condition;
            },
            applyRule() {
                this.section.condition = this.condition;
            },
            parseForm() {
                this.formData = {};
                this.fieldsForSelect = {};
                this.firstField = false;
                // parse form object
                let self = this;
                _.forEach(this.$parent.$parent.form.sections, function(value) {
                    if (self.section.name != value.name) {
                        let controls = {};
                        _.forEach(value.rows, function(value) {
                            _.forEach(value.controls, function(value) {
                                controls[value.name] = {
                                    id: value.name,
                                    label: value.label,
                                    type: value.type
                                };
                                if (value.type == "select") controls[value.name].dataOptions = value.dataOptions;
                            });
                        });
                        self.formData = Object.assign(self.formData, controls);
                        self.fieldsForSelect = Object.assign(self.fieldsForSelect, {
                            [value.name]: {
                                label: value.label,
                                options: controls
                            }
                        });
                    }
                });
                if (Object.keys(this.formData)[0]) {
                    this.firstField = this.formData[Object.keys(this.formData)[0]].id;
                }
            },
        },
        mounted() {
            $("[data-toggle='tooltip']").tooltip();
        }
    }
</script>

<style scoped>

</style>
