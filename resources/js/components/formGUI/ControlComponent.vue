<!--
/**
* Description:
* VueJS Control Component (frontend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div class="controlItem form-group" :class="control.hidden ? '' : control.className" v-if="show">
        <component :is="controlInstance" v-model="control" :label-position="labelPosition"></component>

        <div v-if="control.description" class="description">{{control.description}}</div>

        <div :class="control.name" class="text-danger error-msg" style="display: none;">{{control.errorMsg}}</div>
    </div>
</template>

<script>
    import {CONTROL_TYPES} from "./config/control_constant";

    export default {
        name: "ControlComponent",
        props: ['control', 'labelPosition'],
        data: () => ({
            controlInstance: null,
            show: true,
            rules: {},
            formula: {},
        }),
        created() {
            let self = this;
            if (!CONTROL_TYPES[this.control.type]) {
                console.error(`Control type ${this.control.type} doesn't exist to render.`);
                return;
            }
            // set control
            this.controlInstance = CONTROL_TYPES[this.control.type].source;

            if (this.control.isConditional) {
                this.show = this.control.condition.action_type == 'show' ? false : true;
                this.control.invisible = !this.show;

                _.each(this.control.condition.rules, (rule, key) => {
                    self.rules[key] = false;

                    rule.modName = '';
                    if ('dynamicControl' in self.control) rule.modName = self.control.modName;

                    // set condition when form loaded
                    self.conditionField(rule, key);
                    // add Event to target field
                    $('body').on('change', '[name="'+rule.fieldId+rule.modName+'"]', function(){
                        self.conditionField(rule, key);
                    });

                });

            }

            // Parse Formula object from string
            if (this.control.isCalculated) {
                let fields = this.control.formula.replace(/\s/g, ""); //remove whitespace's
                fields.replace(/\s*\{.*?\}\s*/g, function(match, key, value){
                    let fieldId = match.replace(/\{([\s\S]+)\:/g, "");
                    fieldId = fieldId.replace(/\}/g, "");

                    // for Dynamic Fields
                    if ('dynamicControl' in self.control) fieldId += self.control.modName;

                    self.formula = Object.assign(self.formula, {
                        [fieldId]: {
                            key: key,
                            value: '',
                            text: match
                        }
                    });
                });

                _.each(self.formula, (field, key) => {
                    self.calcField(key); // Calc when started

                    // set events to terget fields
                    $('body').on('change', '[name="'+key+'"]', function(){
                        self.calcField(key); // Calc when changed values
                    });
                });
            }
        },
        methods: {
            toggleField(key, valid) {
                this.rules[key] = valid;
                let show = this.control.condition.logic_type == 'all' ? true : false;
                _.each(this.rules, (value) => {
                    if (this.control.condition.logic_type == 'all') { // AND logic
                        if (value === false) {
                            show = false;
                            return true;
                        }
                    }
                    if (this.control.condition.logic_type == 'any') { // OR logic
                        if (value === true) {
                            show = true;
                            return true;
                        }
                    }
                });
                this.show = this.control.condition.action_type == 'show' ? show : !show;
                this.control.invisible = !this.show;
            },
            conditionField(rule, key) {
                let self = this;
                let field = self.searchInForm(rule.fieldId+rule.modName); // get control from form object
                let valid = false;
                let ruleValue = rule.value;
                let numVal = parseFloat(field.value);
                let stringVal = field.value ? field.value.toString() : '';
                if(field.type == "checkbox") stringVal = field.value ? 1 : 0;

                if(field.type == "datepicker") {
                    ruleValue = parseFloat(moment(rule.value, DATE_FORMAT.toUpperCase()).valueOf());
                    numVal = parseFloat(moment(stringVal, DATE_FORMAT.toUpperCase()).valueOf());
                    stringVal = moment(stringVal, DATE_FORMAT.toUpperCase()).valueOf();
                }

                switch(rule.operator) {
                  case 'is':
                    if (stringVal == ruleValue) valid = true;
                    break;
                  case 'is_not':
                    if (stringVal != ruleValue) valid = true;
                    break;
                  case 'greater':
                    if (numVal > ruleValue) valid = true;
                    break;
                  case 'less':
                    if (numVal < ruleValue) valid = true;
                    break;
                  case 'contain':
                    if (stringVal.indexOf(ruleValue) >= 0) valid = true;
                    break;
                  case 'start':
                    if (stringVal.startsWith(ruleValue)) valid = true;
                    break;
                  case 'end':
                    if (stringVal.endsWith(ruleValue)) valid = true;
                    break;
                  default:
                    valid = false;
                }
                self.toggleField(key, valid);
            },
            calcField(fieldId) {
                let self = this;
                let value = self.searchInForm(fieldId).value; // get control from form object
                self.formula[fieldId].value = value;
                let runCalc = true;
                _.each(this.formula, (item,index) => {
                    // get value from HTML input OR from this.formula[fieldId].value
                    if ( !$('[name="'+index+'"]').val() && !self.formula[index].value ) runCalc = false;
                });
                this.control.value = '';
                if (runCalc) {
                    let formula = this.control.formula.replace(/\s/g, ""); //remove whitespace's
                    formula = formula.replace(/\s*\{.*?\}\s*/g, function(match, key, value) {
                        let fieldId = match.replace(/\{([\s\S]+)\:/g, "");
                        fieldId = fieldId.replace(/\}/g, "");

                        // for Dynamic Fields
                        if ('dynamicControl' in self.control) fieldId += self.control.modName;

                        let val = $('[name="'+fieldId+'"]').val();  // get value from HTML input
                        if (!val) val = self.formula[fieldId].value; // OR from this.formula[fieldId].value

                        return val;
                    });
                    try { // calculate formula
                        this.control.value = eval(formula);
                        this.control.value = Number((this.control.value).toFixed(2));

                        // set value to input element in HTML & fire change event
                        $('[name="'+this.control.fieldName+'"]').val(this.control.value);
                        $('[name="'+this.control.fieldName+'"]').change();
                    } catch (e) {
                        console.log('Formula Error');
                    }
                }
            },

            // search control in form object by fieldName
            searchInForm(fieldName) {
                let self = this;
                let field = false;
                _.forEach(this.$parent.$parent.$parent.form.sections, function(section, key) {
                    if (section.isDynamic) { // search in Dynamic section
                        _.forEach(section.instances, function(instance) {
                            _.forEach(instance, function(row) {
                                _.forEach(row.controls, function(control) {
                                    if (control.fieldName == fieldName) {
                                        field = control;
                                    }
                                });
                            });
                        });
                    } else {
                        _.forEach(section.rows, function(row) {
                            _.forEach(row.controls, function(control) {
                                if (control.fieldName == fieldName) {
                                    field = control;
                                }
                            });
                        });
                    }
                });
                return field;
            },
        }
    }
</script>

<style scoped>

</style>
