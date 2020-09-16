<template>
    <div>
        <div class="row">
            <div class="col-md-6 d-none">
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" readonly class="form-control" :value="control.name">
                </div>
            </div>
            <div class="col-md-6 d-none">
                <div class="form-group">
                    <label>Control type</label>
                    <input type="text" readonly class="form-control" :value="typeFirstUpper">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Unique ID</label>
                    <input type="text"readonly  class="form-control" v-model="control.fieldName"
                           data-toggle="tooltip" title="Field Name must be UNIQUE in Section!">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Width</label>
                    <select class="form-control" v-model="control.className"  @change="applySidebar()">
                        <option v-for="(label, value) in widthOptions" :value="value">{{label}}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <label>
                    <input type="checkbox" name="isRequired" v-model="control.required"> Required?
                </label>

                <label>
                    <input type="checkbox" name="isReadonly" v-model="control.readonly"> Readonly?
                </label>

                <label>
                    <input type="checkbox" name="isHidden" v-model="control.hidden"> Hidden?
                </label>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <label>
                    <input type="checkbox" name="isConditional" v-model="control.isConditional"> Is Conditional
                </label>
                <div class="col-md-12" v-if="control.isConditional">
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
                    <hr>
                </div>
            </div>
        </div>

        <div class="row" v-if="control.type == 'text' || control.type == 'number'">
            <div class="col-sm-12">
                <label>
                    <input type="checkbox" name="isCalculated" v-model="control.isCalculated"> Is Calculated
                </label>
                <div v-if="control.isCalculated">
                    <div class="d-flex justify-content-between">
                        <select class="form-control form-control-sm mr-4" 
                            v-model="formulaSelectModel"
                            @change="addCalcField($event)">
                          <optgroup :label="group.label" v-for="group in fieldsForSelect">
                            <option :value="field.id" v-for="field in group.options">{{field.label}}</option>
                          </optgroup>
                        </select>

                        <div class="btn-group btn-group-sm" role="group">
                            <button @click="addOperator(' + ')" class="btn btn-sm btn-outline-secondary">+</button>
                            <button @click="addOperator(' - ')" class="btn btn-sm btn-outline-secondary">-</button>
                            <button @click="addOperator(' / ')" class="btn btn-sm btn-outline-secondary">/</button>
                            <button @click="addOperator(' * ')" class="btn btn-sm btn-outline-secondary">*</button>
                            <button @click="addOperator(' (')" class="btn btn-sm btn-outline-secondary">(</button>
                            <button @click="addOperator(') ')" class="btn btn-sm btn-outline-secondary">)</button>
                            <button @click="addOperator('.')" class="btn btn-sm btn-outline-secondary">.</button>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                      <textarea class="form-control" :class="{'is-invalid': formulaError}" ref="formula" rows="2" v-model="formula"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {FORM_CONSTANTS} from "sethFormBuilder/config/constants";
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

    export default {
        name: "BaseConfigComponent",
        components: {FontAwesomeIcon},
        props: {
            control: {
                type: Object
            },
        },
        data: () => ({
            widthOptions: FORM_CONSTANTS.WidthOptions,
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
            formula: '',
            formulaError: false,
            formulaSelectModel: null,
            DATE_FORMAT: DATE_FORMAT
        }),
        mounted() {
            $('[data-toggle="tooltip"]').tooltip(); // trigger tooltip
            this.parseForm(); // get all fields from form
            if (this.control.condition) this.condition = this.control.condition; // get from DB
            if (this.control.formula) this.formula = this.control.formula; // get from DB
        },
        watch: { 
            control: function(newVal, oldVal) { // watch if control changed fully
                if (oldVal.name != newVal.name) {
                    this.parseForm();
                    this.formulaSelectModel = null;
                    this.formula = '';
                    if (this.control.condition && this.control.condition.rules.length > 0) {
                        this.condition = this.control.condition;
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
                    if (this.control.formula) {
                        this.formula = this.control.formula;
                    }
                }

            },
            formula: function(newVal) {
                //simple test
                //TODO Validate fields exist if need
                let test = newVal.replace(/\s*\{.*?\}\s*/g, '1');
                this.formulaError = false;
                try {
                    eval(test); 
                } catch (e) {
                    if (e instanceof SyntaxError) {
                        this.formulaError = true;
                    }
                }
                if (!this.formulaError) {
                    this.control.formula = newVal;
                }
            }
        },
        computed: {
            typeFirstUpper() {
                return this.control.type.charAt(0).toUpperCase() + this.control.type.slice(1);
            }
        },
        methods: {
            applySidebar: function() {
                this.$parent.applyEditSidebar();
            },
            addRule() {
                let accept = true;
                _.forEach(this.condition.rules, function(rule) {
                    if (!rule.value) {
                        accept = false;
                    }
                });
                if (accept) {
                    this.condition.rules.push(
                        {
                            fieldId: this.firstField,
                            operator: 'is',
                            value: ''
                        }
                    );
                }
            },
            delRule(index) {
                this.condition.rules.splice(index, 1);
                this.control.condition = this.condition;
            },
            applyRule() {
                this.control.condition = this.condition;
            },
            parseForm() {
                // parse form object
                let self = this;
                self.formData = {};
                self.fieldsForSelect = {};
                _.forEach(this.$parent.$parent.form.sections, function(value) {
                    let controls = {};
                    _.forEach(value.rows, function(value) {
                        _.forEach(value.controls, function(value) {
                            if (self.control.name != value.name) {
                                controls[value.name] = {
                                    id: value.name,
                                    label: value.label,
                                    type: value.type
                                };
                                if (value.type == "select") controls[value.name].dataOptions = value.dataOptions;
                            }
                        });
                    });
                    self.formData = Object.assign(self.formData, controls);
                    self.fieldsForSelect = Object.assign(self.fieldsForSelect, {
                        [value.name]: {
                            label: value.label,
                            options: controls
                        }
                    });
                });
                self.firstField = Object.keys(self.formData)[0];
            },

            // Calculation
            addCalcField(event) {
                this.formula = this.formula + '{'+this.formData[event.target.value].label+':'+event.target.value+'} ';
                this.$refs.formula.focus();
            },
            addOperator(operator) {
                this.formula = this.formula + operator;
                this.$refs.formula.focus();
            },
        }
    }
</script>

<style scoped>

</style>
