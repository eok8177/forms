<template>
    <div class="controlItem form-group" :class="control.className" v-if="show">
        <component :is="controlInstance" v-model="control" :label-position="labelPosition"></component>
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
            rules: {type: Object},
        }),
        created() {
            let self = this;
            if (!CONTROL_TYPES[this.control.type]) {
                console.error(`Control type ${this.control.type} doesn't exist to render.`);
                return;
            }
            // set control
            this.controlInstance = CONTROL_TYPES[this.control.type].source;

            if (this.control.isCalculated) {
                this.show = this.control.condition.action_type == 'show' ? false : true;

                _.each(this.control.condition.rules, (rule, key) => {
                    self.rules[key] = false;

                    // add Event to target field
                    $('body').on('change', '[name="'+rule.fieldId+'"]', function(){
                        let valid = false;
                        let numVal = parseFloat($(this).val());
                        let stringVal = $(this).val().toString();
                        if($(this).attr('type') == "checkbox") stringVal = this.checked ? 1 : 0;

                        switch(rule.operator) {
                          case 'is':
                            if (stringVal == rule.value) valid = true;
                            break;
                          case 'is_not':
                            if (stringVal != rule.value) valid = true;
                            break;
                          case 'greater':
                            if (numVal > rule.value) valid = true;
                            break;
                          case 'less':
                            if (numVal < rule.value) valid = true;
                            break;
                          case 'contain':
                            if (stringVal.indexOf(rule.value) >= 0) valid = true;
                            break;
                          case 'start':
                            if (stringVal.startsWith(rule.value)) valid = true;
                            break;
                          case 'end':
                            if (stringVal.endsWith(rule.value)) valid = true;
                            break;
                          default:
                            valid = false;
                        }
                        self.toggleField(key, valid);
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
            }
        }
    }
</script>

<style scoped>

</style>
