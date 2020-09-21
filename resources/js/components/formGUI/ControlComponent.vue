<template>
    <div class="controlItem form-group" :class="control.hidden ? '' : control.className" v-if="show">
        <component :is="controlInstance" v-model="control" :label-position="labelPosition"></component>

        <div v-if="control.description" class="description">{{control.description}}</div>
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

                _.each(this.control.condition.rules, (rule, key) => {
                    self.rules[key] = false;

                    // add Event to target field
                    $('body').on('change', '[name="'+rule.fieldId+'"]', function(){
                        let valid = false;
                        let ruleValue = rule.value;
                        let numVal = parseFloat($(this).val());
                        let stringVal = $(this).val().toString();
                        if($(this).attr('type') == "checkbox") stringVal = this.checked ? 1 : 0;

                        if($(this).attr('data-type') == "datepicker") {
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
                    if ('dynamicControl' in self.control)  fieldId += self.control.modName;

                    self.formula = Object.assign(self.formula, {
                        [fieldId]: {
                            key: key,
                            value: '',
                            text: match
                        }
                    });
                });

                // set events to terget fields
                _.each(this.formula, (field, key) => {
                    $('body').on('change', '[name="'+key+'"]', function(){
                        self.calcField(key, $(this).val());
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
            },
            calcField(fieldId, value) {
                this.formula[fieldId].value = value;
                let self = this;
                let runCalc = true;
                _.each(this.formula, (item) => {
                    if (!item.value) runCalc = false;
                });
                this.control.value = '';
                if (runCalc) {
                    let formula = this.control.formula.replace(/\s/g, ""); //remove whitespace's
                    formula = formula.replace(/\s*\{.*?\}\s*/g, function(match, key, value) {
                        let fieldId = match.replace(/\{([\s\S]+)\:/g, "");
                        fieldId = fieldId.replace(/\}/g, "");

                        // for Dynamic Fields
                        if ('dynamicControl' in self.control)  fieldId += self.control.modName;

                        return self.formula[fieldId].value; //fill formula by values
                    });
                    try { // calculate formula
                        this.control.value = eval(formula);
                        this.control.value = Number((this.control.value).toFixed(2));
                    } catch (e) {
                        console.log('Formula Error');
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
